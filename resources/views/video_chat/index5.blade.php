<html>
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <style>

        video {
            width: 100%
        }

    </style>
</head>
<body>
    <div id="app" class="container">
        <h1 class="text-center">ビデオチャットのサンプル</h1>
        <br>
        <div class="row">
            <div class="col-12">
                <div class="card" style="padding:15px;">
                    <div v-for="(name,userId) in others">
                        <a href="#" @click.prevent="startVideoChat(userId)">「@{{ name }}」さんと通話を開始する</a>
                    </div>
                </div>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-5">
                <div class="text-center">自分の映像</div>
                <video ref="video-here" autoplay></video>
            </div>
            <div class="col-2 text-center">
                ⇔<br>
                ビデオチャット
            </div>
            <div class="col-5">
                <div class="text-center">相手の映像</div>
                <video ref="video-there" autoplay></video>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/vue@2.5.17/dist/vue.min.js"></script>
    <script src="/js/app.js"></script>
    <script>

        new Vue({
            el: '#app',
            data: {
                pusher: {
                    key: '{{ config('broadcasting.connections.pusher.key') }}',
                    cluster: '{{ config('broadcasting.connections.pusher.options.cluster') }}'
                },
                user: {!! $user !!},
                others: {!! $others !!},
                channel: null,
                stream: null,
                peers: {}
            },
            methods: {
                startVideoChat(userId) {

                    this.getPeer(userId, true);

                },
                getPeer(userId, initiator) {

                    if(this.peers[userId] === undefined) {

                        let peer = new Peer({
                            initiator,
                            stream: this.stream,
                            trickle: false
                        });
                        peer.on('signal', (data) => {

                                this.channel.trigger('client-signal-'+ userId, {
                                    userId: this.user.id,
                                    data: data
                                });

                            })
                            .on('stream', (stream) => {

                                const videoThere = this.$refs['video-there'];
                                videoThere.srcObject = stream;

                            })
                            .on('close', () => {

                                const peer = this.peers[userId];

                                if(peer !== undefined) {

                                    peer.destroy();

                                }

                                delete this.peers[userId];
                            });

                        this.peers[userId] = peer;

                    }

                    return this.peers[userId];

                }
            },
            mounted() {

                // エラー表示できます。
                // Pusher.logToConsole = true;

                // カメラ、音声にアクセス
                navigator.mediaDevices.getUserMedia({ video: true, audio: true })
                    .then((stream) => {

                        const videoHere = this.$refs['video-here'];
                        videoHere.srcObject = stream;
                        this.stream = stream;

                        // Pusher の準備
                        const pusher = new Pusher(this.pusher.key, {
                            authEndpoint: '/auth/video_chat',
                            cluster: this.pusher.cluster,
                            auth: {
                                headers: {
                                    'X-CSRF-Token': document.head.querySelector('meta[name="csrf-token"]').content
                                }
                            }
                        });
                        this.channel = pusher.subscribe('presence-video-chat');
                        this.channel.bind('client-signal-'+ this.user.id, (signal) => {

                            const userId = signal.userId;
                            const peer = this.getPeer(userId, false);
                            peer.signal(signal.data);

                        });

                    });

            }
        });

    </script>
</body>
</html>
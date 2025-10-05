@extends('dashboard.layouts.main')

@section('css')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <style>
        #webcam-capture,
        #webcam-capture video {
            margin: auto;
            border-radius: 2rem;
            object-fit: cover;
        }

        @media (max-width: 425px) {
            #webcam-capture,
            #webcam-capture video {
                width: 300px !important;
                height: 380px !important;
            }
        }

        @media (min-width: 640px) {
            #webcam-capture,
            #webcam-capture video {
                width: 480px !important;
                height: 640px !important;
            }
        }

        @media (min-width: 768px) {
            #webcam-capture,
            #webcam-capture video {
                width: 640px !important;
                height: 480px !important;
            }
        }

        #map {
            border-radius: 1.5rem;
        }
    </style>
@endsection

@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/webcamjs/1.0.26/webcam.min.js"
        integrity="sha512-dQIiHSl2hr3NWKKLycPndtpbh5iaHLo6MwrXm7F0FM5e+kL2U16oE9uIwPHUl6fQBeCthiEuV/rzP3MiAB8Vfw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

    <script>
        Webcam.set({
            width: 640,
            height: 480,
            image_format: 'jpeg',
            jpeg_quality: 90,
            force_flash: false,
            flip_horiz: false,
        });
        Webcam.attach('#webcam-capture');

        let lokasi = document.getElementById('lokasi');
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(successCallback, errorCallBack);
        }

        function successCallback(position) {
            let latitude = position.coords.latitude;
            let longitude = position.coords.longitude;
            lokasi.value = latitude + ", " + longitude;

            let map = L.map('map').setView([latitude, longitude], 17);
            L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
            }).addTo(map);

            let marker = L.marker([latitude, longitude]).addTo(map);
            marker.bindPopup("<b>Anda berada di sini</b>").openPopup();

            let circle = L.circle([{{ $lokasiKantor->latitude ?? 0 }}, {{ $lokasiKantor->longitude ?? 0 }}], {
                color: 'red',
                fillColor: '#f03',
                fillOpacity: 0.5,
                radius: {{ $lokasiKantor->radius ?? 50 }}
            }).addTo(map);
        }

        function errorCallBack() {
            //
        }

        let notifikasi_presensi_masuk = document.getElementById('notifikasi_presensi_masuk');
        let notifikasi_presensi_keluar = document.getElementById('notifikasi_presensi_keluar');
        let notifikasi_presensi_gagal_radius = document.getElementById('notifikasi_presensi_gagal_radius');

        // Tombol utama presensi
        $("#take-presensi").click(function() {
            Webcam.snap(function(uri) {
                image = uri;
            });

            $.ajax({
                type: "POST",
                url: "{{ route('karyawan.presensi.store') }}",
                data: {
                    _token: "{{ csrf_token() }}",
                    image: image,
                    lokasi: lokasi.value,
                    jenis: $("input[name='presensi']").val(),
                },
                cache: false,
                success: function(res) {
                    if (res.status == 200) {
                        if (res.jenis_presensi == "masuk") {
                            notifikasi_presensi_masuk.play();
                        } else if (res.jenis_presensi == "keluar") {
                            notifikasi_presensi_keluar.play();
                        }

                        // Tampilkan modal success
                        document.getElementById('modal_success_title').textContent = "Presensi Berhasil";
                        document.getElementById('modal_success_message').textContent = res.message;
                        document.getElementById('modal_success').checked = true;

                        setTimeout(() => location.href = '{{ route('karyawan.dashboard') }}', 5000);

                    } else if (res.status == 500) {
                        if (res.jenis_error == "radius") {
                            notifikasi_presensi_gagal_radius.play();
                        }

                        // Tampilkan modal error
                        document.getElementById('modal_error_title').textContent = "Presensi Gagal";
                        document.getElementById('modal_error_message').textContent = res.message;
                        document.getElementById('modal_error').checked = true;
                    }
                }
            });
        });
    </script>
@endsection

@section('container')
    <div class="container mx-auto p-4 sm:p-6 lg:p-8">
        {{-- Audio Notifikasi --}}
        <audio id="notifikasi_presensi_masuk">
            <source src="{{ asset('audio/notifikasi_presensi_masuk.mp3') }}" type="audio/mpeg">
        </audio>
        <audio id="notifikasi_presensi_keluar">
            <source src="{{ asset('audio/notifikasi_presensi_keluar.mp3') }}" type="audio/mpeg">
        </audio>
        <audio id="notifikasi_presensi_gagal_radius">
            <source src="{{ asset('audio/notifikasi_presensi_gagal_radius.mp3') }}" type="audio/mpeg">
        </audio>

        <div class="grid grid-cols-1 lg:grid-cols-1 gap-6 lg:gap-8">

            {{-- Card Webcam --}}
            <div
                class="card bg-base-100 shadow-xl border border-base-200 rounded-box transition-all duration-300 hover:shadow-2xl">
                <div class="card-body p-6 sm:p-8">
                    <h2 class="card-title text-base-content text-2xl font-semibold mb-4 text-center opacity-90">
                        Rekam Presensi
                    </h2>

                    <input type="text" name="lokasi" id="lokasi"
                        class="input input-bordered input-primary w-full max-w-xs mx-auto mb-4 opacity-0 h-0 p-0 absolute"
                        hidden>

                    <div id="webcam-capture"
                        class="mx-auto overflow-hidden shadow-lg rounded-2xl border-4 border-primary/20 bg-base-200 flex items-center justify-center">
                        <video autoplay muted playsinline class="w-full h-full object-cover rounded-2xl"></video>
                    </div>

                    <div class="card-actions justify-center mt-6">
                        @if ($presensiKaryawan == null)
                            <input type="text" name="presensi" id="presensi" value="masuk" hidden>
                            <button id="take-presensi"
                                class="btn btn-primary btn-lg btn-wide transition-all duration-300 transform hover:-translate-y-1 hover:shadow-lg">
                                <i class="ri-camera-line text-xl mr-2"></i>
                                Presensi Masuk
                            </button>
                        @elseif ($presensiKaryawan->jam_keluar != null)
                            <button id="take-presensi" class="btn btn-disabled btn-lg btn-wide cursor-not-allowed">
                                <i class="ri-camera-line text-xl mr-2"></i>
                                Presensi Selesai
                            </button>
                        @elseif ($presensiKaryawan != null)
                            <input type="text" name="presensi" id="presensi" value="keluar" hidden>
                            <button id="take-presensi"
                                class="btn btn-secondary btn-lg btn-wide transition-all duration-300 transform hover:-translate-y-1 hover:shadow-lg">
                                <i class="ri-camera-line text-xl mr-2"></i>
                                Presensi Keluar
                            </button>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Card Map --}}
            <div
                class="card bg-base-100 shadow-xl border border-base-200 rounded-box transition-all duration-300 hover:shadow-2xl">
                <div class="card-body p-6 sm:p-8">
                    <h2 class="card-title text-base-content text-2xl font-semibold mb-4 text-center opacity-90">
                        Lokasi Presensi
                    </h2>
                    <div id="map"
                        class="mx-auto h-80 sm:h-96 w-full overflow-hidden shadow-lg rounded-2xl border-4 border-info/20 bg-base-200 transition-all duration-300">
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Success --}}
    <input type="checkbox" id="modal_success" class="modal-toggle" />
    <div class="modal" role="dialog">
        <div class="modal-box bg-base-100 text-center">
            <h3 id="modal_success_title" class="text-lg font-bold text-green-600">Presensi Berhasil</h3>
            <p id="modal_success_message" class="py-4">Data presensi berhasil dikirim.</p>
            <div class="modal-action justify-center">
                <label for="modal_success" class="btn btn-success px-6">OK</label>
            </div>
        </div>
    </div>

    {{-- Modal Error --}}
    <input type="checkbox" id="modal_error" class="modal-toggle" />
    <div class="modal" role="dialog">
        <div class="modal-box bg-base-100 text-center">
            <h3 id="modal_error_title" class="text-lg font-bold text-red-600">Presensi Gagal</h3>
            <p id="modal_error_message" class="py-4">Terjadi kesalahan saat mengirim data presensi.</p>
            <div class="modal-action justify-center">
                <label for="modal_error" class="btn btn-error px-6">OK</label>
            </div>
        </div>
    </div>
@endsection

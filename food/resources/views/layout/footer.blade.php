<footer class="footer_section">
    <div class="container">
        @php
        $footer = App\Models\Footer::first();
        @endphp
        <div class="row">
            <div class="col-md-4 footer-col">
                <div class="footer_contact">
                    <h4>
                        تماس با ما
                    </h4>
                    <div class="contact_link_box">
                        <a href="">
                            <i class="bi bi-geo-alt-fill"></i>
                            <span>
                                {{ $footer->contact_address }}
                            </span>
                        </a>
                        <a href="">
                            <div class="d-flex justify-content-center">
                                <i class="bi bi-telephone-fill" aria-hidden="true"></i>
                                <p class="my-0" style="direction: ltr;">
                                    {{ $footer->contact_phone }}
                                </p>
                            </div>
                        </a>
                        <a href="">
                            <i class="bi bi-envelope-fill"></i>
                            <span>
                                {{ $footer->contact_email }}
                            </span>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-md-4 footer-col">
                <div class="footer_detail">
                    <a href="" class="footer-logo">
                        {{ $footer->title }}
                    </a>
                    <p>
                        {{ $footer->body }}
                    </p>
                    <div class="footer_social">
                        @if($footer->telegram_link !== null)
                        <a href="{{ $footer->telegram_link }}">
                            <i class="bi bi-telegram"></i>
                        </a>
                        @endif
                        @if($footer->whatsapp_link !== null)
                        <a href="{{ $footer->whatsapp_link }}">
                            <i class="bi bi-whatsapp"></i>
                        </a>
                        @endif
                        @if($footer->instagram_link !== null)
                        <a href="{{ $footer->instagram_link }}">
                            <i class="bi bi-instagram"></i>
                        </a>
                        @endif
                        @if($footer->youtube_link !== null)
                        <a href="{{ $footer->youtube_link }}">
                            <i class="bi bi-youtube"></i>
                        </a>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-md-4 footer-col">
                <h4>
                    ساعت کاری
                </h4>
                <p>
                    {{ $footer->work_days }}
                </p>
                <p>
                    {{ $footer->work_hour_from }} صبح تا {{ $footer->work_hour_to }} شب
                </p>
            </div>
        </div>
        <div class="footer-info">
            <p>
                {{ $footer->copyright }}
            </p>
        </div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous">
</script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-right',
        iconColor: 'white',
        customClass: {
            popup: 'colored-toast',
        },
        showConfirmButton: false,
        timer: 5000,
        timerProgressBar: true,
    })

    @if (session('success'))
        Toast.fire({
            icon: 'success',
            title: '{{ session('success') }}',
        })
    @elseif (session('error'))
        Toast.fire({
            icon: 'error',
            title: '{{ session('error') }}',
        })
    @elseif (session('warning'))
        Toast.fire({
            icon: 'warning',
            title: '{{ session('warning') }}',
        })
    @endif
</script>

@yield('script')
</body>

</html>
@if (session('success') || session('error') || session('warning') || session('info'))
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const notyf = new Notyf({
            duration: 4000,
            ripple: false, 
            position: {
                x: 'right',
                y: 'top',
            },
            types: [
                {
                    type: 'warning',
                    background: 'orange',
                    icon: {
                        className: 'material-icons',
                        tagName: 'i',
                        text: 'report_problem',
                    },
                },
                {
                    type: 'info',
                    background: '#17a2b8',
                    icon: {
                        className: 'material-icons',
                        tagName: 'i',
                        text: 'info',
                    },
                },
            ]
        });

        @if (session('success'))
            notyf.success("{{ session('success') }}");
        @endif

        @if (session('error'))
            notyf.error("{{ session('error') }}");
        @endif

        @if (session('warning'))
            notyf.open({ type: 'warning', message: "{{ session('warning') }}" });
        @endif

        @if (session('info'))
            notyf.open({ type: 'info', message: "{{ session('info') }}" });
        @endif
    });
</script>
@endif

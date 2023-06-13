<form action="/metode-pembayaran/{{ $masjid->id }}" method="get" id="middle">
    <input type="hidden" name="masjid_id" value="{{ $masjid->id }}">
    <input type="hidden" name="donasi_id" value="{{ $donasi_id }}">
    <input type="hidden" name="nomor" value="{{ $add['nomor'] }}">
    <input type="hidden" name="bank" value="{{ $add['bank'] }}">
    <input type="hidden" name="anonim" value="{{ $add['anonim'] }}">
    <input type="hidden" name="nominal" value="{{ $add['nominal'] }}">
    </form>
    <script>
        const form = document.querySelector('#middle');
        form.submit();
    </script>
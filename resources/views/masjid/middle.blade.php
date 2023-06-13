<form action="/register" method="post" id="middle">
@csrf
<input type="hidden" name="name" value="{{ $data['name'] }}">
<input type="hidden" name="email" value="{{ $data['email'] }}">
<input type="hidden" name="password" value="{{ $data['password'] }}">
<input type="hidden" name="password_confirmation" value="{{ $data['password_confirmation'] }}">
<input type="hidden" name="phone" value="{{ $data['phone'] }}">
<input type="hidden" name="masjid_id" value="{{ $data['masjid_id'] }}">
<input type="hidden" name="pengurus" value="true">
</form>
<script>
    const form = document.querySelector('#middle');
    form.submit();
</script>
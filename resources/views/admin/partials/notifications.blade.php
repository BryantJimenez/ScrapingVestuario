@if (session('type') && session('title') && session('msg'))
<script type="text/javascript">
	Lobibox.notify('{{ session('type') }}', {
		title: '{{ session('title') }}',
		sound: true,
		msg: '{{ session('msg') }}'
	});
</script>
@endif
<!DOCTYPE html>
<html>
<head>
	<title>电影院购票</title>
</head>
<body>
	<hr>
	@foreach($data as $k=>$v)
	<button id="cinema" value="{{$v->c_id}}">{{$v->name}}</button>
	@endforeach
	<hr>
</body>
<script type="text/javascript" src="/static/plugins/jquery/jquery.min.js"></script>
<script>
	$(document).on("click","#cinema",function(){
		alert(11);
	})
</script>
</html>
<!DOCTYPE html>
<html>
<head>
	<title>抽奖页面</title>
</head>
<body>
	<!-- -->
	<h2>抽奖页面</h2>
	<button id="btn-prize">开始抽奖</button>
</body>
<script type="text/javascript" src="/static/plugins/jquery/jquery.min.js"></script>
<script>
	$(document).on("click","#btn-prize",function(){
		$.ajax({
			url:"{{url('/prize/add')}}",
			type: "get",
             dataType: 'json',
			success:function(res){
				if(res.errno==400003){
                        window.location.href = '/login'
                    }
				alert(res.data.level);
				console.log(res);
			}
		})
	})
</script>
</html>
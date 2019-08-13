<html>
<head>

</head>

<body>
    @if($type == 1)
    <video src="{{$video}}"  width="510" height="310" controls="controls">
        Your browser does not support the video tag.
    </video>
    @else
        <img src="{{$video}}" alt="" style="width: 100%;height:100%;">
    @endif
</body>
</html>
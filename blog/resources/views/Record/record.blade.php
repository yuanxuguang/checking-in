<html>
<head>

</head>

<body>
    @if($type == '4')
        @if($info)
        @foreach($info as $i)
            <video src="{{$i->path}}"  width="510" height="310" controls="controls">
                Your browser does not support the video tag.
            </video>
        @endforeach
        @endif
    @else
        @if($info)
        @foreach($info as $i)
            <img src="{{$i->path}}" alt="" style="width:20%;">
        @endforeach
        @endif
    @endif
</body>
</html>
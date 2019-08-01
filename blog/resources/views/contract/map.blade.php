<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0" />

    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="apple-mobile-web-app-status-bar-style" content="black" />
    <title>DEMO</title>
    <style>
        body{
            position: absolute;
            top: 0;
            bottom: 0;
            left: 0;
            right: 0;
            margin: 0;
        }
        iframe{
            width: 100%;
            height: 100%;
        }

    </style>
</head>
<body>
<iframe id="test" src='https://m.amap.com/picker/?key=608d75903d29ad471362f8c58c550daf' style="width:600px;height: 600px;"></iframe>

<script>
    (function(){
        var iframe = document.getElementById('test').contentWindow;
        document.getElementById('test').onload = function(){
            iframe.postMessage('hello','https://m.amap.com/picker/');
        };
        window.addEventListener("message", function(e){
            console.log(e.data);
            alert('您选择了:' + e.data.name + ',' + e.data.location)
        }, false);
    }())
</script>

<script type='text/javascript'>
    var mock = {
        log: function(result) {
            window.parent.setIFrameResult('log', result);
        }
    }
    console = mock;
    window.Konsole = {
        exec: function(code) {
            code = code || '';
            try {
                var result = window.eval(code);
                window.parent.setIFrameResult('result', result);
            } catch (e) {
                window.parent.setIFrameResult('error', e);
            }
        }
    }
</script><div style="position: absolute;margin: -99999px;">
    <script type='text/javascript'>
        var mock = {
            log: function(result) {
                window.parent.setIFrameResult('log', result);
            }
        }
        console = mock;
        window.Konsole = {
            exec: function(code) {
                code = code || '';
                try {
                    var result = window.eval(code);
                    window.parent.setIFrameResult('result', result);
                } catch (e) {
                    window.parent.setIFrameResult('error', e);
                }
            }
        }
    </script>
</div></body>
</html>
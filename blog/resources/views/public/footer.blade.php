<script>

    $(function(){
        var script=document.createElement("script");
        script.type="text/javascript";
        script.src="http://www.microsoftTranslator.com/ajax/v3/WidgetV3.ashx?siteData=ueOIGRSKkd965FeEGM5JtQ**";
        document.getElementsByTagName('head')[0].appendChild(script);

        var resultm = sessionStorage.getItem("language");

        document.onreadystatechange = function () {


            if (document.readyState == 'complete') {

                if(resultm==="English"){
                    Microsoft.Translator.Widget.Translate('zh-CHS', 'en', onProgress, onError, onComplete, onRestoreOriginal, 2000);
                }else if(resultm==="Français"){
                    Microsoft.Translator.Widget.Translate('zh-CHS', 'fr', onProgress, onError, onComplete, onRestoreOriginal, 2000);
                }else  if(resultm==="zhongwen"){
                    Microsoft.Translator.Widget.Translate('zh-CHS', 'zh-CHS', onProgress, onError, onComplete, onRestoreOriginal, 2000);
                }else if(resultm==="fanti"){
                    Microsoft.Translator.Widget.Translate('zh-CHS', 'zh-HK', onProgress, onError, onComplete, onRestoreOriginal, 2000);
                }
            }
        }

        function onProgress(value) {
            $("#WidgetFloaterPanels").hide();
        }
        function onError(error) {
            $("#WidgetFloaterPanels").hide();
        }
        function onComplete() {
            $("#WidgetFloaterPanels").hide();
        }
        function onRestoreOriginal() {
            $("#WidgetFloaterPanels").hide();
        }
    });

    function changeLanguage(){

        var result = $("#change").val();

        if(result==="English"){
            sessionStorage.setItem("language", "English");
        }else if(result==="zhongwen"){
            sessionStorage.setItem("language", "zhongwen");
        }else if(result ==="fanti"){
            sessionStorage.setItem("language", "fanti");
        }

        window.location.reload();//刷新当前页面.

    }
</script>
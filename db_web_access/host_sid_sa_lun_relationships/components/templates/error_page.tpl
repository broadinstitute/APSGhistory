<html>
<head>
    <title></title>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <link rel="stylesheet" type="text/css" href="phpgen.css" />
    <link rel="stylesheet" type="text/css" href="common_style.css" />
    <script type="text/javascript" src="libs/jquery/jquery.js"></script>
</head>
<body class="error_page">
    <div align="center" style="width: 100%; height: auto;">
        <div class="error_box">
            <h3>{$Captions->GetMessageString('Error')}</h3>
            <div class="error_sugg">{$Captions->GetMessageString('CriticalErrorSuggestions')}</div>
            <div class="error_sugg"><a href="javascript:;" onclick="$('.error_details').slideToggle('normal');">{$Captions->GetMessageString('ShowErrorDetails')}</a></div>
            <div class="error_details">{$Message}</div>
            <script>$('.error_details').hide();</script>
            <div style="margin-top: 20px; text-align: center;"><a href="javascript:;" onclick="window.history.back();">{$Captions->GetMessageString('Back')}</a></div><br>
        </div>
    </div>
</body>
</html>
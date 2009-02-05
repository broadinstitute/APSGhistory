<%@ taglib uri="sitemesh-decorator" prefix="decorator" %>
<%@ taglib uri="/webwork" prefix="ww" %>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
    <decorator:usePage id="sitemeshPage"/>
</head>

<body onload="<decorator:getProperty property="body.onload"/>">
    <decorator:body/>
</body>

</html>
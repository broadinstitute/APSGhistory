<%@ page contentType="text/html;charset=UTF-8" language="java" %>
<%@ taglib uri="/webwork" prefix="ww" %>
<html>
    <head>
        <title><ww:property value="getText('identity.title')"/></title>
        <meta name="section" content="home" />
        <meta name="subsection" content="identifier" />
        <link rel="openid.server" href="<ww:property value="baseURL"/>server.openid" />
        <link rel="openid.delegate" href="<ww:property value="identifier"/>">
    </head>

    <body>

            <div class="crowdForm">
                <div class="formTitle">
                    <h2><ww:property value="getText('identity.title')"/></h2>
                </div>

                <div class="identity-block">
                    &nbsp;
                    <div class="identity-img">
                        <br/>
                    </div>
                    <div class="identity-bar">
                        <ww:property value="identifier"/>
                    </div>

                </div>

                <div class="identity-info">
                    <ww:property value="getText('myidentity.text')"/>

                </div>

                <div class="formFooter wizardFooter">
                    &nbsp;
                </div>
            </div>


    </body>
</html>
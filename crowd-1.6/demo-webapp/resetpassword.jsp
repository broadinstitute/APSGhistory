<%@ page contentType="text/html;charset=UTF-8" language="java" %>
<%@ taglib uri="/webwork" prefix="ww" %>
<html>
    <head>
        <title><ww:property value="getText('resetpassword.title')"/></title>
    </head>

    <body>
        <form method="post" action="<ww:url namespace="/console" action="resetpassword" method="update" />" name="login">

            <h2><ww:property value="getText('resetpassword.title')"/></h2>

            <ww:if test="actionErrors">
                  <ww:iterator value="actionErrors">
                      <p class="error">
                          <ww:property /><br/>
                      </p>
                  </ww:iterator>
              </ww:if>

            <ww:textfield name="username" size="30" >
                <ww:param name="label" value="getText('username.label')" />
            </ww:textfield>

            <div class="row">
                <p style="text-align: right;">
                    <input type="submit" class="button" value="<ww:property value="getText('update.label')"/> &raquo;"/>
                </p>
            </div>

        </form>
    </body>
</html>
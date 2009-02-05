<%--
  -- WebWork, Web Application Framework
  --
  -- Distributable under LGPL license.
  -- See terms of license at opensource.org
  --
  --
  -- select.jsp
  --
  -- Required Parameters:
  --   * label  - The description that will be used to identfy the control.
  --   * name   - The name of the attribute to put and pull the result from.
  --              Equates to the NAME parameter of the HTML SELECT tag.
  --   * list   - Iterator that will provide the options for the control.
  --              Equates to the HTML OPTION tags in the SELECT and supplies
  --              both the NAME and VALUE parameters of the OPTION tag.
  --
  -- Optional Parameters:
  --   * labelposition   - determines were the label will be place in relation
  --                       to the control.  Default is to the left of the control.
  --   * size            - SIZE parameter of the HTML SELECT tag.
  --   * disabled        - DISABLED parameter of the HTML SELECT tag.
  --   * tabindex        - tabindex parameter of the HTML SELECT tag.
  --   * onchange        - onkeyup parameter of the HTML SELECT tag.
  --   * size            - SIZE parameter of the HTML SELECT tag.
  --   * multiple        - MULTIPLE parameter of the HTML SELECT tag.
  --   * headerKey       - Combined with headerValue parameter specifies the top of select list
  --   * headerValue     - see above
  --
  --%>
<%@ taglib uri="/webwork" prefix="webwork" %>
<%@ include file="controlheader.jsp" %>
<select name="<webwork:property value="parameters['name']"/>"
         <webwork:if test="parameters['id'] != null">id="<webwork:property value="parameters['id']"/>"</webwork:if>
         <webwork:if test="parameters['disabled'] == true">disabled="disabled"</webwork:if>
         <webwork:if test="parameters['size'] != null">size="<webwork:property value="parameters['size']"/>"</webwork:if>
         <webwork:if test="parameters['tabindex'] != null">tabindex="<webwork:property value="parameters['tabindex']"/>"</webwork:if>
         <webwork:if test="parameters['onchange'] != null">onchange="<webwork:property value="parameters['onchange']"/>"</webwork:if>
         <webwork:if test="parameters['multiple'] == true">multiple="multiple"</webwork:if>
>
    <webwork:if test="parameters['headerKey'] != null && parameters['headerValue'] != null">
       <option value="<webwork:property value="parameters['headerKey']"/>">
          <webwork:property value="parameters['headerValue']"/>
       </option>
    </webwork:if>
    <webwork:iterator value="parameters.list">
        <webwork:push value="[0]"/>

       <webwork:if test="parameters.listKey != null">
            <webwork:set name="itemKey" value="stack.findString(parameters.listKey)" />
       </webwork:if>
        <webwork:else>
            <webwork:set name="itemKey" value="[0]" />
        </webwork:else>

        <webwork:if test="parameters.listValue != null">
            <webwork:set name="itemValue" value="stack.findString(parameters.listValue)" />
        </webwork:if>
         <webwork:else>
             <webwork:set name="itemValue" value="[0]" />
         </webwork:else>

        <option value="<webwork:property value="#itemKey"/>" <webwork:if test="parameters['nameValue'] == #itemKey || parameters['selectedValue'] == #itemKey ">selected</webwork:if> >
            <webwork:property value="#itemValue"/>
        <webwork:property value="stack.pop"/>
       </option>

    </webwork:iterator>
</select>
<%@ include file="controlfooter.jsp" %>
<%--
  -- WebWork, Web Application Framework
  --
  -- Distributable under LGPL license.
  -- See terms of license at opensource.org
  --
  --
  -- combobox.jsp
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
  --   * size       - SIZE parameter of the HTML INPUT tag.
  --   * maxlength  - MAXLENGTH parameter of the HTML INPUT tag.
  --   * disabled   - DISABLED parameter of the HTML INPUT tag.
  --   * onkeyup    - onkeyup parameter of the HTML INPUT tag.
  --   * tabindex  - tabindex parameter of the HTML INPUT tag.
  --   * onchange  - onkeyup parameter of the HTML INPUT tag.
  --
  --%>
<%@ taglib uri="/webwork" prefix="webwork" %>
<%@ include file="controlheader.jsp" %>
<input type="text"
       name="<webwork:property value="parameters['name']"/>"
            <webwork:if test="parameters['size']">size="<webwork:property value="parameters['size']"/>"</webwork:if>
            <webwork:if test="parameters['maxlength']">maxlength="<webwork:property value="parameters['maxlength']"/>"</webwork:if>
            <webwork:if test="parameters['nameValue']">value="<webwork:property value="parameters['nameValue']"/>"</webwork:if>
            <webwork:if test="parameters['disabled'] == true">disabled="disabled"</webwork:if>
            <webwork:if test="parameters['onkeyup']">onkeyup="<webwork:property value="parameters['onkeyup']"/>"</webwork:if>
            <webwork:if test="parameters['tabindex']">tabindex="<webwork:property value="parameters['tabindex']"/>"</webwork:if>
            <webwork:if test="parameters['onchange']">onchange="<webwork:property value="parameters['onchange']"/>"</webwork:if>
            <webwork:if test="parameters['id']">id="<webwork:property value="parameters['id']"/>"</webwork:if>
/><br/>
   <webwork:if test="parameters['list']">
      <select onChange="this.form.elements['<webwork:property value="parameters['name']"/>'].value=this.options[this.selectedIndex].value"
            <webwork:if test="{parameters['disabled']}">disabled="disabled"</webwork:if>
      >
            <webwork:iterator value=".">
               <option value="<webwork:property value="."/>" <webwork:if test="parameters['nameValue'] == .">selected="selected"</webwork:if>><webwork:property value="."/>
               </option>
            </webwork:iterator>
      </select>
   </webwork:if>
<%@ include file="controlfooter.jsp" %>
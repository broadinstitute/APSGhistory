<%--
  -- WebWork, Web Application Framework
  --
  -- Distributable under LGPL license.
  -- See terms of license at opensource.org
  --
  --
  -- textarea.jsp
  --
  -- Required Parameters:
  --   * label  - The description that will be used to identfy the control.
  --   * name   - The name of the attribute to put and pull the result from.
  --              Equates to the NAME parameter of the HTML INPUT tag.
  --   * cols   - Width of the textarea.  Equates to the COLS parameter of
  --              HTML tag TEXTAREA.
  --   * rows   - Height of the textarea.  Equates to the ROWS parameter of
  --              HTML tag TEXTAREA.
  --
  -- Optional Parameters:
  --   * labelposition   - determines were the label will be place in relation
  --                       to the control.  Default is to the left of the control.
  --   * disabled  - DISABLED parameter of the HTML TEXTAREA tag.
  --   * readonly  - READONLY parameter of the HTML TEXTAREA tag.
  --   * onkeyup   - onkeyup parameter of the HTML TEXTAREA tag.
  --   * tabindex  - tabindex parameter of the HTML TEXTAREA tag.
  --   * onchange  - onkeyup parameter of the HTML TEXTAREA tag.
  --
  --%>
<%@ taglib uri="/webwork" prefix="webwork" %>
<%@ include file="controlheader.jsp" %>

<textarea name="<webwork:property value="parameters['name']"/>"
          cols="<webwork:property value="parameters['cols']"/>"
          rows="<webwork:property value="parameters['rows']"/>"
          wrap="virtual"
        <webwork:if test="parameters['disabled'] == true">disabled="disabled"</webwork:if>
        <webwork:if test="parameters['readonly'] != null">readonly="readonly"</webwork:if>
        <webwork:if test="parameters['onkeyup'] != null">onkeyup="<webwork:property value="parameters['onkeyup']"/>"</webwork:if>
        <webwork:if test="parameters['tabindex'] != null">tabindex="<webwork:property value="parameters['tabindex']"/>"</webwork:if>
        <webwork:if test="parameters['onchange'] != null">onchange="<webwork:property value="parameters['onchange']"/>"</webwork:if>
><webwork:property value="parameters['nameValue']"/></textarea>
<%@ include file="controlfooter.jsp" %>
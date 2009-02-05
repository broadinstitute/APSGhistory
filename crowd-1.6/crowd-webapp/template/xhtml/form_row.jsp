<%@ taglib uri="/webwork" prefix="ww" %>

<div class="fieldArea required">
    <ww:if test="parameters['warning'] != null">
        <div class="errorBox">
            <ww:property value="parameters['warning']" escape="false"/>
        </div>
    </ww:if>

    <label class="fieldLabelArea" for="Description">
        <ww:property value="parameters['label']" escape="false"/>:
    </label>

    <div class="fieldValueArea">
        <ww:property value="parameters['value']" escape="false"/>
        <div class="fieldDescription">
            <ww:property value="parameters['description']" escape="false"/>
        </div>
    </div>
</div>
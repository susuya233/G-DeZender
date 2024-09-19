<?php
/*********************/
/*                   */
/*  Version : 5.1.0  */
/*  Author  : RM     */
/*  Comment : 071223 */
/*                   */
/*********************/

class AnalyticFormBase
{

    public $flowForm = NULL;
    public $formData = NULL;
    public $formElement = NULL;
    public $elementName = NULL;
    public $elementId = NULL;
    public $elementValue = NULL;
    public $elementTitle = NULL;
    public $fieldArray = NULL;
    public $elementRequire = NULL;
    public $elementClass = NULL;
    public $elementThousand = NULL;
    public $prcsItem = NULL;
    public $prcsItemCapacity = NULL;
    public $prcsItemAuto = NULL;
    public $prcsItemRequired = NULL;
    public $getValueControl = NULL;
    public $relationField = NULL;
    public $dateComputeControl = NULL;
    public $itemId = NULL;
    public $flowType = NULL;
    public $flowId = NULL;
    public $formName = NULL;
    public $runId = NULL;
    public $runSeq = NULL;
    public $prcsId = NULL;
    public $flowPrcs = NULL;
    public $prcsDate = NULL;
    public $prcsDateTime = NULL;
    public $opFlag = NULL;

    public function __construct( $flowForm )
    {
        $this->flowForm = $flowForm;
        $this->formElement = $this->html_element( $this->flowForm );
        $this->itemId = 0;
        $i = 0;
        for ( ; $i < ( $this->formElement ); ++$i )
        {
            $ELEMENT = $this->formElement[$i];
            $this->elementName[$i] = $this->get_attr( $ELEMENT, "NAME" );
            $this->elementId[$i] = $this->get_attr( $ELEMENT, "ID" );
            $this->elementValue[$i] = $this->get_attr( $ELEMENT, "VALUE" );
            $EITLE = $this->get_attr( $ELEMENT, "TITLE" );
            $EITLE = ( "+", "＋", $EITLE );
            $EITLE = ( "#", "＃", $EITLE );
            $this->elementTitle[$i] = $EITLE;
            $this->elementClass[$i] = $this->get_attr( $ELEMENT, "CLASS" );
            $this->elementThousand[$i] = $this->get_attr( $ELEMENT, "THOUSANDFORMAT" );
            $this->elementFormat[$i] = $this->get_attr( $ELEMENT, "FORMAT" );
        }
    }

    public function formDataTrans( )
    {
        foreach ( $this->formData as $key => $val )
        {
            $formFieldValue[$val['ITEM_ID']] = $this->fieldValueFilter( $val['ITEM_DATA'] );
        }
        return $formFieldValue;
    }

    public function fieldValueFilter( $value )
    {
        switch ( $value )
        {
        case "{宏控件}" :
            return $value = "";
        case "{会签字段}" :
            return $value = "";
        case "{编辑器}" :
            return $value = "";
        case "{人员选择}" :
            return $value = "";
        case "{部门选择}" :
            return $value = "";
        case "{角色选择}" :
            return $value = "";
        default :
            return $value;
        }
    }

    public function fieldCanEdit( $elementTitle, $elementClass = "" )
    {
        if ( $this->flowType == 1 )
        {
            if ( $elementClass == "HTML_SIGNATURE" || $elementClass == "SIGNATURE_PICTURE" )
            {
                if ( ( $this->prcsItem, $elementTitle ) )
                {
                    return true;
                }
                else
                {
                    return false;
                }
            }
            else if ( $this->opFlag == 1 && ( $this->prcsItem, $elementTitle ) )
            {
                return true;
            }
            else
            {
                return false;
            }
        }
        else if ( $elementClass == "HTML_SIGNATURE" || $elementClass == "SIGNATURE_PICTURE" )
        {
            return true;
        }
        else if ( $this->opFlag == 1 )
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    public function addIdNameRequiredEvent( $elementName, $elementId, $reqiured, $opFlag, $elementStr )
    {
        return ( "<{$elementName}", "<{$elementName} field_required='{$reqiured}' onchange=\"checkRequired(this,'{$elementId}','{$opFlag}');\" onkeyup=\"checkRequired(this,'{$elementId}','{$opFlag}');\" onblur=\"checkRequired(this,'{$elementId}','{$opFlag}');\"", $elementStr );
    }

    public function addIdName( $elementName, $elementId, $elementStr )
    {
        return ( "<{$elementName}", "<{$elementName} name='DATA_{$elementId}' id='DATA_{$elementId}'", $elementStr );
    }

    public function html_element( $PRINT_MODEL )
    {
        $POS = 0;
        $LEN = ( $PRINT_MODEL );
        $I = 0;
        $J = 0;
        while ( $POS < $LEN )
        {
            $POS = ( $PRINT_MODEL, "<", $POS );
            if ( $POS === FALSE )
            {
                break;
            }
            if ( ( $PRINT_MODEL, $POS + 1, 1 ) == "/" )
            {
                $POS += 2;
                continue;
            }
            $POS1 = ( $PRINT_MODEL, " ", $POS );
            $POS2 = ( $PRINT_MODEL, ">", $POS );
            if ( $POS2 < $POS1 )
            {
                $POS1 = $POS2;
            }
            $ELEMENT_NAME = ( $PRINT_MODEL, $POS + 1, $POS1 - $POS - 1 );
            switch ( $ELEMENT_NAME )
            {
            case "INPUT" :
                $ELEMENT = ( $PRINT_MODEL, $POS, $POS2 - $POS + 1 );
                $ELEMENT_ARRAY[$I++] = $ELEMENT;
                $POS = $POS2 + 1;
                break;
            case "SELECT" :
                $POS2 = ( $PRINT_MODEL, "</SELECT>", $POS2 + 1 );
                $ELEMENT = ( $PRINT_MODEL, $POS, $POS2 - $POS + 9 );
                $ELEMENT_ARRAY[$I++] = $ELEMENT;
                $POS = $POS2 + 9;
                break;
            case "TEXTAREA" :
                $POS2 = ( $PRINT_MODEL, "</TEXTAREA>", $POS2 + 1 );
                $ELEMENT = ( $PRINT_MODEL, $POS, $POS2 - $POS + 11 );
                $ELEMENT_ARRAY[$I++] = $ELEMENT;
                $POS = $POS2 + 11;
                break;
            case "IMG" :
                $ELEMENT = ( $PRINT_MODEL, $POS, $POS2 - $POS + 1 );
                if ( $this->get_attr( $ELEMENT, "CLASS" ) )
                {
                    $ELEMENT_ARRAY[$I++] = $ELEMENT;
                }
                $POS = $POS2 + 1;
                break;
            default :
                $POS = $POS2 + 1;
                break;
            }
        }
        return $ELEMENT_ARRAY;
    }

    public function get_attr( $ELEMENT, $ATTR )
    {
        $POS = ( $ELEMENT, " " );
        $E_NAME = ( $ELEMENT, 1, $POS - 1 );
        $ATTR_DATA == "";
        if ( $ATTR == "NAME" )
        {
            $ATTR_DATA = $E_NAME;
        }
        else if ( $ATTR == "TITLE" || $ATTR == "CLASS" || $ATTR == "DATAFLD" || $ATTR == "DATASRC" || $ATTR == "THOUSANDFORMAT" || $ATTR == "ID" || $ATTR == "FORMAT" )
        {
            if ( $ATTR == "TITLE" || $ATTR == "CLASS" || $ATTR == "THOUSANDFORMAT" || $ATTR == "ID" || $ATTR == "FORMAT" )
            {
                $ATTR = ( $ATTR );
            }
            else if ( $ATTR == "DATAFLD" )
            {
                $ATTR = "dataFld";
            }
            else if ( $ATTR == "DATASRC" )
            {
                $ATTR = "dataSrc";
            }
            $bool = ( $ELEMENT, $ATTR ) || ( $ELEMENT, ( $ATTR ) );
            if ( $bool )
            {
                $p = ( $ELEMENT, "{$ATTR}=" );
                if ( $p === false )
                {
                    $att = ( $ATTR );
                    $p = ( $ELEMENT, "{$att}=" );
                }
                $POS = $p + ( $ATTR ) + 1;
                $POS1 = ( $ELEMENT, ">", $POS );
                if ( $ATTR == "dataSrc" || $ATTR == "title" )
                {
                    ++$POS;
                    $POS2 = ( $ELEMENT, "\"", $POS );
                }
                else
                {
                    $POS2 = ( $ELEMENT, " ", $POS );
                }
                if ( $POS2 < $POS1 && $POS2 != 0 )
                {
                    $POS1 = $POS2;
                }
                $ATTR_DATA = ( $ELEMENT, $POS, $POS1 - $POS );
                $ATTR_DATA = ( "\"", "", $ATTR_DATA );
            }
        }
        else if ( $ATTR == "VALUE" )
        {
            if ( $E_NAME == "INPUT" || $E_NAME == "IMG" )
            {
                if ( !( $ELEMENT, "type=\"checkbox\"" ) )
                {
                    $POS = ( $ELEMENT, "value=" );
                    if ( 0 < $POS )
                    {
                        if ( $E_NAME == "INPUT" )
                        {
                            $POS = ( $ELEMENT, "value=" ) + 6;
                            $POS1 = ( $ELEMENT, ">", $POS );
                            $ATTR_DATA = ( $ELEMENT, $POS, $POS1 - $POS );
                        }
                        else if ( $E_NAME == "IMG" )
                        {
                            $value_pattern = "/value=\"[^\"]*\"/";
                            ( $value_pattern, $ELEMENT, $value_pattern_array );
                            $value = $value_pattern_array[0][0];
                            $ATTR_DATA = ( $value, 7, ( $value ) - 8 );
                        }
                    }
                    else
                    {
                        $ATTR_DATA = "";
                    }
                }
                else if ( ( $ELEMENT, " checked=\"checked\"" ) )
                {
                    $ATTR_DATA = "on";
                }
                $ATTR_DATA = ( "\"", "", $ATTR_DATA );
            }
            else if ( $E_NAME == "TEXTAREA" )
            {
                $POS = ( $ELEMENT, ">" ) + 1;
                $POS1 = ( $ELEMENT, "<", $POS );
                $ATTR_DATA = ( $ELEMENT, $POS, $POS1 - $POS );
            }
            else if ( $E_NAME == "SELECT" )
            {
                $POS = ( $ELEMENT, ">" ) + 1;
                $POS1 = ( $ELEMENT, "</SELECT>", $POS );
                $ATTR_DATA = ( $ELEMENT, $POS, $POS1 - $POS );
            }
        }
        return $ATTR_DATA;
    }

}

?>

<?php

/* @CoreHome/_dataTableActions.twig */
class __TwigTemplate_25acf321f80804eea0ee6a3c885cffa9ca6a1431902a5e54ca764e65cd18529d extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        echo " ";
        $context["randomIdForDropdown"] = twig_random($this->env, 999999);
        // line 2
        echo "
    ";
        // line 3
        if (($this->getAttribute(($context["properties"] ?? $this->getContext($context, "properties")), "show_footer", array()) && $this->getAttribute(($context["properties"] ?? $this->getContext($context, "properties")), "show_footer_icons", array()))) {
            // line 4
            echo "
        <a class='dropdown-button dropdownConfigureIcon dataTableAction'
           href='javascript:;'
           data-activates='dropdownConfigure";
            // line 7
            echo \Piwik\piwik_escape_filter($this->env, ($context["randomIdForDropdown"] ?? $this->getContext($context, "randomIdForDropdown")), "html", null, true);
            echo "'><span class=\"icon-configure\"></span></a>

        ";
            // line 9
            $context["activeFooterIcon"] = "";
            // line 10
            echo "        ";
            $context["numIcons"] = 0;
            // line 11
            echo "        ";
            ob_start();
            // line 12
            echo "            <ul id='dropdownVisualizations";
            echo \Piwik\piwik_escape_filter($this->env, ($context["randomIdForDropdown"] ?? $this->getContext($context, "randomIdForDropdown")), "html", null, true);
            echo "' class='dropdown-content dataTableFooterIcons'>
                ";
            // line 13
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable(($context["footerIcons"] ?? $this->getContext($context, "footerIcons")));
            foreach ($context['_seq'] as $context["_key"] => $context["footerIconGroup"]) {
                // line 14
                echo "                    ";
                $context['_parent'] = $context;
                $context['_seq'] = twig_ensure_traversable($this->getAttribute($context["footerIconGroup"], "buttons", array()));
                foreach ($context['_seq'] as $context["_key"] => $context["footerIcon"]) {
                    if ($this->getAttribute($context["footerIcon"], "icon", array())) {
                        // line 15
                        echo "                        <li>
                            ";
                        // line 16
                        $context["numIcons"] = (($context["numIcons"] ?? $this->getContext($context, "numIcons")) + 1);
                        // line 17
                        echo "                            ";
                        $context["isActiveEcommerceView"] = ($this->getAttribute(($context["clientSideParameters"] ?? null), "abandonedCarts", array(), "any", true, true) && ((($this->getAttribute(                        // line 18
$context["footerIcon"], "id", array()) == "ecommerceOrder") && ($this->getAttribute(($context["clientSideParameters"] ?? $this->getContext($context, "clientSideParameters")), "abandonedCarts", array()) == 0)) || (($this->getAttribute(                        // line 19
$context["footerIcon"], "id", array()) == "ecommerceAbandonedCart") && ($this->getAttribute(($context["clientSideParameters"] ?? $this->getContext($context, "clientSideParameters")), "abandonedCarts", array()) == 1))));
                        // line 20
                        echo "                            <a class=\"";
                        echo \Piwik\piwik_escape_filter($this->env, $this->getAttribute($context["footerIconGroup"], "class", array()), "html", null, true);
                        echo " tableIcon ";
                        if ((($this->getAttribute(($context["clientSideParameters"] ?? $this->getContext($context, "clientSideParameters")), "viewDataTable", array()) == $this->getAttribute($context["footerIcon"], "id", array())) || ($context["isActiveEcommerceView"] ?? $this->getContext($context, "isActiveEcommerceView")))) {
                            echo "activeIcon";
                            $context["activeFooterIcon"] = $this->getAttribute($context["footerIcon"], "icon", array());
                        }
                        echo "\"
                               data-footer-icon-id=\"";
                        // line 21
                        echo \Piwik\piwik_escape_filter($this->env, $this->getAttribute($context["footerIcon"], "id", array()), "html", null, true);
                        echo "\">
                                ";
                        // line 22
                        if ((is_string($__internal_47f4cbfe5cd961fefff3d6092dad9d0f18508270f5b8f09ddb9be01e9d08eee6 = $this->getAttribute($context["footerIcon"], "icon", array())) && is_string($__internal_31ce6df50fa1d7e1cb3fb328b94078dda78e710e85a2c3d37c8dff150fa76820 = "icon-") && ('' === $__internal_31ce6df50fa1d7e1cb3fb328b94078dda78e710e85a2c3d37c8dff150fa76820 || 0 === strpos($__internal_47f4cbfe5cd961fefff3d6092dad9d0f18508270f5b8f09ddb9be01e9d08eee6, $__internal_31ce6df50fa1d7e1cb3fb328b94078dda78e710e85a2c3d37c8dff150fa76820)))) {
                            // line 23
                            echo "                                    <span title=\"";
                            echo \Piwik\piwik_escape_filter($this->env, $this->getAttribute($context["footerIcon"], "title", array()), "html", null, true);
                            echo "\" class=\"";
                            echo \Piwik\piwik_escape_filter($this->env, $this->getAttribute($context["footerIcon"], "icon", array()), "html", null, true);
                            echo "\"></span>
                                ";
                        } else {
                            // line 25
                            echo "                                    <img width=\"16\" height=\"16\" title=\"";
                            echo \Piwik\piwik_escape_filter($this->env, $this->getAttribute($context["footerIcon"], "title", array()), "html", null, true);
                            echo "\" src=\"";
                            echo \Piwik\piwik_escape_filter($this->env, $this->getAttribute($context["footerIcon"], "icon", array()), "html", null, true);
                            echo "\"/>
                                ";
                        }
                        // line 27
                        echo "                                ";
                        if ($this->getAttribute($context["footerIcon"], "title", array(), "any", true, true)) {
                            echo "<span>";
                            echo \Piwik\piwik_escape_filter($this->env, $this->getAttribute($context["footerIcon"], "title", array()), "html", null, true);
                            echo "</span>";
                        }
                        // line 28
                        echo "                            </a>
                        </li>
                    ";
                    }
                }
                $_parent = $context['_parent'];
                unset($context['_seq'], $context['_iterated'], $context['_key'], $context['footerIcon'], $context['_parent'], $context['loop']);
                $context = array_intersect_key($context, $_parent) + $_parent;
                // line 31
                echo "                    <li class=\"divider\"></li>
                ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['footerIconGroup'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 33
            echo "            </ul>
        ";
            $context["visualizationIcons"] = ('' === $tmp = ob_get_clean()) ? '' : new Twig_Markup($tmp, $this->env->getCharset());
            // line 35
            echo "
        ";
            // line 36
            if ((($context["activeFooterIcon"] ?? $this->getContext($context, "activeFooterIcon")) && (($context["numIcons"] ?? $this->getContext($context, "numIcons")) > 1))) {
                // line 37
                echo "            <a class=\"dropdown-button dataTableAction activateVisualizationSelection\"
               href=\"javascript:;\"
               data-activates=\"dropdownVisualizations";
                // line 39
                echo \Piwik\piwik_escape_filter($this->env, ($context["randomIdForDropdown"] ?? $this->getContext($context, "randomIdForDropdown")), "html", null, true);
                echo "\">
                ";
                // line 40
                if ((is_string($__internal_df25b249e8032dda6dc3137a838fd990a416959548c94f8425532121100fae31 = ($context["activeFooterIcon"] ?? $this->getContext($context, "activeFooterIcon"))) && is_string($__internal_a5dde24d5633a975c5852669bf3c8dfcf68bd3af2d30a10379487d4d0246da9f = "icon-") && ('' === $__internal_a5dde24d5633a975c5852669bf3c8dfcf68bd3af2d30a10379487d4d0246da9f || 0 === strpos($__internal_df25b249e8032dda6dc3137a838fd990a416959548c94f8425532121100fae31, $__internal_a5dde24d5633a975c5852669bf3c8dfcf68bd3af2d30a10379487d4d0246da9f)))) {
                    // line 41
                    echo "                    <span title=\"";
                    echo \Piwik\piwik_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("CoreHome_ChangeVisualization")), "html_attr");
                    echo "\" class=\"";
                    echo \Piwik\piwik_escape_filter($this->env, ($context["activeFooterIcon"] ?? $this->getContext($context, "activeFooterIcon")), "html", null, true);
                    echo "\"></span>
                ";
                } else {
                    // line 43
                    echo "                    <img title=\"";
                    echo \Piwik\piwik_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("CoreHome_ChangeVisualization")), "html_attr");
                    echo "\" width=\"16\" height=\"16\" src=\"";
                    echo \Piwik\piwik_escape_filter($this->env, ($context["activeFooterIcon"] ?? $this->getContext($context, "activeFooterIcon")), "html", null, true);
                    echo "\"/>
                ";
                }
                // line 45
                echo "            </a>
            ";
                // line 46
                echo ($context["visualizationIcons"] ?? $this->getContext($context, "visualizationIcons"));
                echo "
        ";
            }
            // line 48
            echo "
        ";
            // line 49
            if ($this->getAttribute(($context["properties"] ?? $this->getContext($context, "properties")), "show_export", array())) {
                // line 50
                echo "            ";
                $context["requestParams"] = twig_jsonencode_filter($this->getAttribute(($context["properties"] ?? $this->getContext($context, "properties")), "request_parameters_to_modify", array()));
                // line 51
                echo "
            ";
                // line 52
                $context["formats"] = array("CSV" => "CSV", "TSV" => "TSV (Excel)", "XML" => "XML", "JSON" => "Json", "PHP" => "PHP", "HTML" => "HTML");
                // line 53
                echo "            ";
                if ($this->getAttribute(($context["properties"] ?? $this->getContext($context, "properties")), "show_export_as_rss_feed", array())) {
                    // line 54
                    echo "                ";
                    $context["formats"] = twig_array_merge(($context["formats"] ?? $this->getContext($context, "formats")), array("RSS" => "RSS"));
                    // line 55
                    echo "            ";
                }
                // line 56
                echo "
            <a class=\"dataTableAction activateExportSelection\" piwik-report-export
               report-title=\"";
                // line 58
                echo \Piwik\piwik_escape_filter($this->env, $this->getAttribute(($context["properties"] ?? $this->getContext($context, "properties")), "title", array()), "html_attr");
                echo "\" request-params=\"";
                echo \Piwik\piwik_escape_filter($this->env, ($context["requestParams"] ?? $this->getContext($context, "requestParams")), "html_attr");
                echo "\"
               api-method=\"";
                // line 59
                echo \Piwik\piwik_escape_filter($this->env, $this->getAttribute(($context["properties"] ?? $this->getContext($context, "properties")), "apiMethodToRequestDataTable", array()), "html", null, true);
                echo "\" report-formats=\"";
                echo \Piwik\piwik_escape_filter($this->env, twig_jsonencode_filter(($context["formats"] ?? $this->getContext($context, "formats"))), "html_attr");
                echo "\"
               href='javascript:;' title=\"";
                // line 60
                echo \Piwik\piwik_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("General_ExportThisReport")), "html_attr");
                echo "\"
               ><span class=\"icon-export\"></span></a>
        ";
            }
            // line 63
            echo "
        ";
            // line 64
            if ($this->getAttribute(($context["properties"] ?? $this->getContext($context, "properties")), "show_export_as_image_icon", array())) {
                // line 65
                echo "            <a class=\"dataTableAction tableIcon\" href=\"javascript:;\" id=\"dataTableFooterExportAsImageIcon\"
               onclick=\"\$(this).closest('.dataTable').find('div.jqplot-target').trigger('piwikExportAsImage'); return false;\"
               title=\"";
                // line 67
                echo \Piwik\piwik_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("General_ExportAsImage")), "html", null, true);
                echo "\">
                <span class=\"icon-image\"></span>
            </a>
        ";
            }
            // line 71
            echo "
        ";
            // line 72
            if ((call_user_func_array($this->env->getFunction('isPluginLoaded')->getCallable(), array("Annotations")) &&  !$this->getAttribute(($context["properties"] ?? $this->getContext($context, "properties")), "hide_annotations_view", array()))) {
                // line 73
                echo "            <a class='dataTableAction annotationView'
               href='javascript:;' title=\"";
                // line 74
                echo \Piwik\piwik_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("Annotations_Annotations")), "html_attr");
                echo "\"
            ><span class=\"icon-annotation\"></span></a>
        ";
            }
            // line 77
            echo "
        ";
            // line 78
            if ($this->getAttribute(($context["properties"] ?? $this->getContext($context, "properties")), "show_search", array())) {
                // line 79
                echo "            <a class='dropdown-button dataTableAction searchAction'
               href='javascript:;' title=\"";
                // line 80
                echo \Piwik\piwik_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("General_Search")), "html_attr");
                echo "\"
               ><span class=\"icon-search\"></span>
                <span class=\"icon-close\" title=\"";
                // line 82
                echo \Piwik\piwik_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("CoreHome_CloseSearch")), "html_attr");
                echo "\"></span>
                <input id=\"widgetSearch_";
                // line 83
                echo \Piwik\piwik_escape_filter($this->env, $this->getAttribute(($context["properties"] ?? $this->getContext($context, "properties")), "report_id", array()), "html", null, true);
                echo "\"
                       title=\"";
                // line 84
                echo \Piwik\piwik_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("CoreHome_DataTableHowToSearch")), "html_attr");
                echo "\"
                       type=\"text\"
                       class=\"dataTableSearchInput browser-default\" />
            </a>
        ";
            }
            // line 89
            echo "
        <ul id='dropdownConfigure";
            // line 90
            echo \Piwik\piwik_escape_filter($this->env, ($context["randomIdForDropdown"] ?? $this->getContext($context, "randomIdForDropdown")), "html", null, true);
            echo "' class='dropdown-content tableConfiguration'>
            ";
            // line 91
            if ($this->getAttribute(($context["properties"] ?? $this->getContext($context, "properties")), "show_flatten_table", array())) {
                // line 92
                echo "                ";
                if (($this->getAttribute(($context["clientSideParameters"] ?? null), "flat", array(), "any", true, true) && ($this->getAttribute(($context["clientSideParameters"] ?? $this->getContext($context, "clientSideParameters")), "flat", array()) == 1))) {
                    // line 93
                    echo "                    <li>
                        <div class=\"configItem dataTableIncludeAggregateRows\"></div>
                    </li>
                ";
                }
                // line 97
                echo "                <li>
                    <div class=\"configItem dataTableFlatten\"></div>
                </li>
            ";
            }
            // line 101
            echo "            ";
            if ($this->getAttribute(($context["properties"] ?? $this->getContext($context, "properties")), "show_exclude_low_population", array())) {
                // line 102
                echo "                <li>
                    <div class=\"configItem dataTableExcludeLowPopulation\"></div>
                </li>
            ";
            }
            // line 106
            echo "            ";
            if ( !twig_test_empty((($this->getAttribute(($context["properties"] ?? null), "show_pivot_by_subtable", array(), "any", true, true)) ? (_twig_default_filter($this->getAttribute(($context["properties"] ?? null), "show_pivot_by_subtable", array()))) : ("")))) {
                // line 107
                echo "                <li>
                    <div class=\"configItem dataTablePivotBySubtable\"></div>
                </li>
            ";
            }
            // line 111
            echo "        </ul>
    ";
        }
    }

    public function getTemplateName()
    {
        return "@CoreHome/_dataTableActions.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  313 => 111,  307 => 107,  304 => 106,  298 => 102,  295 => 101,  289 => 97,  283 => 93,  280 => 92,  278 => 91,  274 => 90,  271 => 89,  263 => 84,  259 => 83,  255 => 82,  250 => 80,  247 => 79,  245 => 78,  242 => 77,  236 => 74,  233 => 73,  231 => 72,  228 => 71,  221 => 67,  217 => 65,  215 => 64,  212 => 63,  206 => 60,  200 => 59,  194 => 58,  190 => 56,  187 => 55,  184 => 54,  181 => 53,  179 => 52,  176 => 51,  173 => 50,  171 => 49,  168 => 48,  163 => 46,  160 => 45,  152 => 43,  144 => 41,  142 => 40,  138 => 39,  134 => 37,  132 => 36,  129 => 35,  125 => 33,  118 => 31,  109 => 28,  102 => 27,  94 => 25,  86 => 23,  84 => 22,  80 => 21,  70 => 20,  68 => 19,  67 => 18,  65 => 17,  63 => 16,  60 => 15,  54 => 14,  50 => 13,  45 => 12,  42 => 11,  39 => 10,  37 => 9,  32 => 7,  27 => 4,  25 => 3,  22 => 2,  19 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source(" {% set randomIdForDropdown = random(999999) %}

    {% if properties.show_footer and properties.show_footer_icons %}

        <a class='dropdown-button dropdownConfigureIcon dataTableAction'
           href='javascript:;'
           data-activates='dropdownConfigure{{ randomIdForDropdown }}'><span class=\"icon-configure\"></span></a>

        {% set activeFooterIcon = '' %}
        {% set numIcons = 0 %}
        {% set visualizationIcons %}
            <ul id='dropdownVisualizations{{ randomIdForDropdown }}' class='dropdown-content dataTableFooterIcons'>
                {% for footerIconGroup in footerIcons %}
                    {% for footerIcon in footerIconGroup.buttons if footerIcon.icon %}
                        <li>
                            {% set numIcons = numIcons + 1 %}
                            {% set isActiveEcommerceView = clientSideParameters.abandonedCarts is defined and
                            ((footerIcon.id == 'ecommerceOrder' and clientSideParameters.abandonedCarts == 0) or
                            (footerIcon.id == 'ecommerceAbandonedCart' and clientSideParameters.abandonedCarts == 1)) %}
                            <a class=\"{{ footerIconGroup.class }} tableIcon {% if clientSideParameters.viewDataTable == footerIcon.id or isActiveEcommerceView %}activeIcon{% set activeFooterIcon = footerIcon.icon %}{% endif %}\"
                               data-footer-icon-id=\"{{ footerIcon.id }}\">
                                {% if footerIcon.icon starts with 'icon-' %}
                                    <span title=\"{{ footerIcon.title }}\" class=\"{{ footerIcon.icon }}\"></span>
                                {% else %}
                                    <img width=\"16\" height=\"16\" title=\"{{ footerIcon.title }}\" src=\"{{ footerIcon.icon }}\"/>
                                {% endif %}
                                {% if footerIcon.title is defined %}<span>{{ footerIcon.title }}</span>{% endif %}
                            </a>
                        </li>
                    {% endfor %}
                    <li class=\"divider\"></li>
                {% endfor %}
            </ul>
        {% endset %}

        {% if activeFooterIcon and numIcons > 1 %}
            <a class=\"dropdown-button dataTableAction activateVisualizationSelection\"
               href=\"javascript:;\"
               data-activates=\"dropdownVisualizations{{ randomIdForDropdown }}\">
                {% if activeFooterIcon starts with 'icon-' %}
                    <span title=\"{{ 'CoreHome_ChangeVisualization'|translate|e('html_attr') }}\" class=\"{{ activeFooterIcon }}\"></span>
                {% else %}
                    <img title=\"{{ 'CoreHome_ChangeVisualization'|translate|e('html_attr') }}\" width=\"16\" height=\"16\" src=\"{{ activeFooterIcon }}\"/>
                {% endif %}
            </a>
            {{ visualizationIcons|raw }}
        {% endif %}

        {% if properties.show_export %}
            {% set requestParams = properties.request_parameters_to_modify|json_encode %}

            {% set formats = {\"CSV\":\"CSV\",\"TSV\":\"TSV (Excel)\",\"XML\":\"XML\",\"JSON\":\"Json\",\"PHP\":\"PHP\",\"HTML\":\"HTML\"} %}
            {% if properties.show_export_as_rss_feed %}
                {% set formats = formats|merge({\"RSS\": \"RSS\"}) %}
            {% endif %}

            <a class=\"dataTableAction activateExportSelection\" piwik-report-export
               report-title=\"{{ properties.title|e('html_attr') }}\" request-params=\"{{ requestParams|e('html_attr') }}\"
               api-method=\"{{ properties.apiMethodToRequestDataTable }}\" report-formats=\"{{ formats|json_encode|e('html_attr') }}\"
               href='javascript:;' title=\"{{ 'General_ExportThisReport'|translate|e('html_attr') }}\"
               ><span class=\"icon-export\"></span></a>
        {% endif %}

        {% if properties.show_export_as_image_icon %}
            <a class=\"dataTableAction tableIcon\" href=\"javascript:;\" id=\"dataTableFooterExportAsImageIcon\"
               onclick=\"\$(this).closest('.dataTable').find('div.jqplot-target').trigger('piwikExportAsImage'); return false;\"
               title=\"{{ 'General_ExportAsImage'|translate }}\">
                <span class=\"icon-image\"></span>
            </a>
        {% endif %}

        {% if isPluginLoaded('Annotations') and not properties.hide_annotations_view %}
            <a class='dataTableAction annotationView'
               href='javascript:;' title=\"{{ 'Annotations_Annotations'|translate|e('html_attr') }}\"
            ><span class=\"icon-annotation\"></span></a>
        {% endif %}

        {% if properties.show_search %}
            <a class='dropdown-button dataTableAction searchAction'
               href='javascript:;' title=\"{{ 'General_Search'|translate|e('html_attr') }}\"
               ><span class=\"icon-search\"></span>
                <span class=\"icon-close\" title=\"{{ 'CoreHome_CloseSearch'|translate|e('html_attr') }}\"></span>
                <input id=\"widgetSearch_{{ properties.report_id }}\"
                       title=\"{{ 'CoreHome_DataTableHowToSearch'|translate|e('html_attr') }}\"
                       type=\"text\"
                       class=\"dataTableSearchInput browser-default\" />
            </a>
        {% endif %}

        <ul id='dropdownConfigure{{ randomIdForDropdown }}' class='dropdown-content tableConfiguration'>
            {% if properties.show_flatten_table %}
                {% if clientSideParameters.flat is defined and clientSideParameters.flat == 1 %}
                    <li>
                        <div class=\"configItem dataTableIncludeAggregateRows\"></div>
                    </li>
                {% endif %}
                <li>
                    <div class=\"configItem dataTableFlatten\"></div>
                </li>
            {% endif %}
            {% if properties.show_exclude_low_population %}
                <li>
                    <div class=\"configItem dataTableExcludeLowPopulation\"></div>
                </li>
            {% endif %}
            {% if properties.show_pivot_by_subtable|default is not empty %}
                <li>
                    <div class=\"configItem dataTablePivotBySubtable\"></div>
                </li>
            {% endif %}
        </ul>
    {% endif %}", "@CoreHome/_dataTableActions.twig", "/var/www/html/plugins/CoreHome/templates/_dataTableActions.twig");
    }
}

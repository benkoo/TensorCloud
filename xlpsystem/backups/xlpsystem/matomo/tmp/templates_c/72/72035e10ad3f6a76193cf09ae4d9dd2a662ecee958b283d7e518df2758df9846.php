<?php

/* @UserCountryMap/visitorMap.twig */
class __TwigTemplate_cd41102564b45c4d1fc51b3c11ac2d6cbe73ebbf2fce2b0eae83c7b76154206d extends Twig_Template
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
        echo "<section class=\"card\">
<div class=\"UserCountryMap card-content\" style=\"position:relative; overflow:hidden;\">
    <div class=\"UserCountryMap_container\">
        <div class=\"UserCountryMap_map\" style=\"overflow:hidden;\"></div>
        <div class=\"UserCountryMap-overlay UserCountryMap-title\">
            <div class=\"content\">
                <!--<div class=\"map-title\" style=\"font-weight:bold; color:#9A9386;\"></div>-->
                <div class=\"map-stats\" style=\"color:#565656;\"></div>
            </div>
        </div>
        <div class=\"UserCountryMap-overlay UserCountryMap-legend\">
            <div class=\"content\">
            </div>
        </div>
        <div class=\"UserCountryMap-tooltip UserCountryMap-info\">
            <div class=\"content unlocated-stats\" data-tpl=\"";
        // line 16
        echo \Piwik\piwik_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("UserCountryMap_Unlocated")), "html", null, true);
        echo "\">
            </div>
        </div>
        <div class=\"UserCountryMap-info-btn\" data-tooltip-target=\".UserCountryMap-tooltip\"></div>
    </div>
    <div class=\"mapWidgetStatus\">
        ";
        // line 22
        if (($context["noData"] ?? $this->getContext($context, "noData"))) {
            // line 23
            echo "            <div class=\"pk-emptyDataTable\">";
            echo \Piwik\piwik_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("CoreHome_ThereIsNoDataForThisReport")), "html", null, true);
            echo "</div>
        ";
        } else {
            // line 25
            echo "            <span class=\"loadingPiwik\">
                <img src=\"plugins/Morpheus/images/loading-blue.gif\" />
                ";
            // line 27
            echo \Piwik\piwik_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("General_LoadingData")), "html", null, true);
            echo "...
            </span>
        ";
        }
        // line 30
        echo "    </div>
    <div class=\"dataTableFeatures\" style=\"padding-top:0;\">
        <div class=\"dataTableFooterIcons\">
            <div class=\"dataTableFooterWrap\" var=\"graphVerticalBar\">
                <img class=\"UserCountryMap-activeItem dataTableFooterActiveItem\" src=\"plugins/Morpheus/images/data_table_footer_active_item.png\" style=\"left: 25px;\" />

                <div class=\"tableIconsGroup\">
                    <span class=\"tableAllColumnsSwitch\">
                        <a class=\"UserCountryMap-btn-zoom tableIcon\" format=\"table\">
                            <img src=\"plugins/Morpheus/images/zoom-out.png\" title=\"Zoom to world\" />
                        </a>
                    </span>
                </div>
                <div class=\"tableIconsGroup UserCountryMap-view-mode-buttons\">
                    <span class=\"tableAllColumnsSwitch\">
                        <a var=\"tableAllColumns\" class=\"UserCountryMap-btn-region tableIcon activeIcon\" format=\"tableAllColumns\"
                           data-region=\"";
        // line 46
        echo \Piwik\piwik_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("UserCountryMap_Regions")), "html", null, true);
        echo "\" data-country=\"";
        echo \Piwik\piwik_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("UserCountryMap_Countries")), "html", null, true);
        echo "\">
                            <img src=\"plugins/UserCountryMap/images/regions.png\" title=\"Show visitors per region/country\" />
                            <span style=\"margin:0;\">";
        // line 48
        echo \Piwik\piwik_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("UserCountryMap_Countries")), "html", null, true);
        echo "</span>&nbsp;
                        </a>
                        <a var=\"tableGoals\" class=\"UserCountryMap-btn-city tableIcon inactiveIco\" format=\"tableGoals\">
                            <img src=\"plugins/UserCountryMap/images/cities.png\" title=\"Show visitors per city\" />
                            <span style=\"margin:0;\">";
        // line 52
        echo \Piwik\piwik_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("UserCountryMap_Cities")), "html", null, true);
        echo "</span>&nbsp;
                        </a>
                    </span>
                </div>
            </div>

            <select class=\"userCountryMapSelectMetrics browser-default\" style=\"float:right;margin-right:25px;margin-bottom:10px;max-width: 10em;font-size:10px;height: auto;\">
                ";
        // line 59
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["metrics"] ?? $this->getContext($context, "metrics")));
        foreach ($context['_seq'] as $context["_key"] => $context["metric"]) {
            // line 60
            echo "                    <option value=\"";
            echo \Piwik\piwik_escape_filter($this->env, $this->getAttribute($context["metric"], 0, array(), "array"), "html", null, true);
            echo "\" ";
            if (($this->getAttribute($context["metric"], 0, array(), "array") == ($context["defaultMetric"] ?? $this->getContext($context, "defaultMetric")))) {
                echo "selected=\"selected\"";
            }
            echo "}>";
            echo \Piwik\piwik_escape_filter($this->env, $this->getAttribute($context["metric"], 1, array(), "array"), "html", null, true);
            echo "</option>
                ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['metric'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 62
        echo "            </select>
            <select class=\"userCountryMapSelectCountry browser-default\" style=\"height: auto;\">
                <option value=\"world\">";
        // line 64
        echo \Piwik\piwik_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("UserCountryMap_WorldWide")), "html", null, true);
        echo "</option>
                <option disabled=\"disabled\">––––––</option>
                ";
        // line 66
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["continents"] ?? $this->getContext($context, "continents")));
        foreach ($context['_seq'] as $context["code"] => $context["continent"]) {
            // line 67
            echo "                    <option value=\"";
            echo \Piwik\piwik_escape_filter($this->env, $context["code"], "html", null, true);
            echo "\">";
            echo \Piwik\piwik_escape_filter($this->env, $context["continent"], "html", null, true);
            echo "</option>
                ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['code'], $context['continent'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 69
        echo "                <option disabled=\"disabled\">––––––</option>
            </select>
        </div>
    </div>
</div>
</section>

";
        // line 76
        if ( !($context["noData"] ?? $this->getContext($context, "noData"))) {
            // line 77
            echo "<!-- configure some piwik vars -->
<script type=\"text/javascript\">
    var visitorMap,
    config = JSON.parse('";
            // line 80
            echo \Piwik\piwik_escape_filter($this->env, \Piwik\piwik_escape_filter($this->env, ($context["config"] ?? $this->getContext($context, "config")), "js"), "html", null, true);
            echo "');
    config._ = JSON.parse('";
            // line 81
            echo \Piwik\piwik_escape_filter($this->env, \Piwik\piwik_escape_filter($this->env, ($context["localeJSON"] ?? $this->getContext($context, "localeJSON")), "js"), "html", null, true);
            echo "');
    config.reqParams = JSON.parse('";
            // line 82
            echo \Piwik\piwik_escape_filter($this->env, \Piwik\piwik_escape_filter($this->env, ($context["reqParamsJSON"] ?? $this->getContext($context, "reqParamsJSON")), "js"), "html", null, true);
            echo "');
    config.countryNames = JSON.parse('";
            // line 83
            echo \Piwik\piwik_escape_filter($this->env, \Piwik\piwik_escape_filter($this->env, twig_jsonencode_filter(($context["countriesByIso"] ?? $this->getContext($context, "countriesByIso"))), "js"), "html", null, true);
            echo "');

    \$('.UserCountryMap').addClass('dataTable');

    if (\$('#dashboardWidgetsArea').length) {
        // dashboard mode
        var \$widgetContent = \$('.UserCountryMap').parents('.widgetContent').first();

        \$widgetContent.on('widget:create',function (evt, widget) {
            visitorMap = new UserCountryMap.VisitorMap(config, widget);
        }).on('widget:maximise',function (evt) {
                    visitorMap.resize();
                }).on('widget:minimise',function (evt) {
                    visitorMap.resize();
                }).on('widget:destroy', function (evt) {
                    visitorMap.destroy();
                });
    } else {
        // stand-alone mode
        visitorMap = new UserCountryMap.VisitorMap(config);
    }

</script>
";
        }
    }

    public function getTemplateName()
    {
        return "@UserCountryMap/visitorMap.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  176 => 83,  172 => 82,  168 => 81,  164 => 80,  159 => 77,  157 => 76,  148 => 69,  137 => 67,  133 => 66,  128 => 64,  124 => 62,  109 => 60,  105 => 59,  95 => 52,  88 => 48,  81 => 46,  63 => 30,  57 => 27,  53 => 25,  47 => 23,  45 => 22,  36 => 16,  19 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("<section class=\"card\">
<div class=\"UserCountryMap card-content\" style=\"position:relative; overflow:hidden;\">
    <div class=\"UserCountryMap_container\">
        <div class=\"UserCountryMap_map\" style=\"overflow:hidden;\"></div>
        <div class=\"UserCountryMap-overlay UserCountryMap-title\">
            <div class=\"content\">
                <!--<div class=\"map-title\" style=\"font-weight:bold; color:#9A9386;\"></div>-->
                <div class=\"map-stats\" style=\"color:#565656;\"></div>
            </div>
        </div>
        <div class=\"UserCountryMap-overlay UserCountryMap-legend\">
            <div class=\"content\">
            </div>
        </div>
        <div class=\"UserCountryMap-tooltip UserCountryMap-info\">
            <div class=\"content unlocated-stats\" data-tpl=\"{{ 'UserCountryMap_Unlocated'|translate }}\">
            </div>
        </div>
        <div class=\"UserCountryMap-info-btn\" data-tooltip-target=\".UserCountryMap-tooltip\"></div>
    </div>
    <div class=\"mapWidgetStatus\">
        {% if noData %}
            <div class=\"pk-emptyDataTable\">{{ 'CoreHome_ThereIsNoDataForThisReport'|translate }}</div>
        {% else %}
            <span class=\"loadingPiwik\">
                <img src=\"plugins/Morpheus/images/loading-blue.gif\" />
                {{ 'General_LoadingData'|translate }}...
            </span>
        {% endif %}
    </div>
    <div class=\"dataTableFeatures\" style=\"padding-top:0;\">
        <div class=\"dataTableFooterIcons\">
            <div class=\"dataTableFooterWrap\" var=\"graphVerticalBar\">
                <img class=\"UserCountryMap-activeItem dataTableFooterActiveItem\" src=\"plugins/Morpheus/images/data_table_footer_active_item.png\" style=\"left: 25px;\" />

                <div class=\"tableIconsGroup\">
                    <span class=\"tableAllColumnsSwitch\">
                        <a class=\"UserCountryMap-btn-zoom tableIcon\" format=\"table\">
                            <img src=\"plugins/Morpheus/images/zoom-out.png\" title=\"Zoom to world\" />
                        </a>
                    </span>
                </div>
                <div class=\"tableIconsGroup UserCountryMap-view-mode-buttons\">
                    <span class=\"tableAllColumnsSwitch\">
                        <a var=\"tableAllColumns\" class=\"UserCountryMap-btn-region tableIcon activeIcon\" format=\"tableAllColumns\"
                           data-region=\"{{ 'UserCountryMap_Regions'|translate }}\" data-country=\"{{ 'UserCountryMap_Countries'|translate }}\">
                            <img src=\"plugins/UserCountryMap/images/regions.png\" title=\"Show visitors per region/country\" />
                            <span style=\"margin:0;\">{{ 'UserCountryMap_Countries'|translate }}</span>&nbsp;
                        </a>
                        <a var=\"tableGoals\" class=\"UserCountryMap-btn-city tableIcon inactiveIco\" format=\"tableGoals\">
                            <img src=\"plugins/UserCountryMap/images/cities.png\" title=\"Show visitors per city\" />
                            <span style=\"margin:0;\">{{ 'UserCountryMap_Cities'|translate }}</span>&nbsp;
                        </a>
                    </span>
                </div>
            </div>

            <select class=\"userCountryMapSelectMetrics browser-default\" style=\"float:right;margin-right:25px;margin-bottom:10px;max-width: 10em;font-size:10px;height: auto;\">
                {% for metric in metrics %}
                    <option value=\"{{ metric[0] }}\" {% if metric[0] == defaultMetric %}selected=\"selected\"{% endif %}}>{{ metric[1] }}</option>
                {% endfor %}
            </select>
            <select class=\"userCountryMapSelectCountry browser-default\" style=\"height: auto;\">
                <option value=\"world\">{{ 'UserCountryMap_WorldWide'|translate }}</option>
                <option disabled=\"disabled\">––––––</option>
                {% for code,continent in continents %}
                    <option value=\"{{ code }}\">{{ continent }}</option>
                {% endfor %}
                <option disabled=\"disabled\">––––––</option>
            </select>
        </div>
    </div>
</div>
</section>

{% if not noData %}
<!-- configure some piwik vars -->
<script type=\"text/javascript\">
    var visitorMap,
    config = JSON.parse('{{ config|e('js') }}');
    config._ = JSON.parse('{{ localeJSON|e('js') }}');
    config.reqParams = JSON.parse('{{ reqParamsJSON|e('js') }}');
    config.countryNames = JSON.parse('{{ countriesByIso|json_encode|e('js') }}');

    \$('.UserCountryMap').addClass('dataTable');

    if (\$('#dashboardWidgetsArea').length) {
        // dashboard mode
        var \$widgetContent = \$('.UserCountryMap').parents('.widgetContent').first();

        \$widgetContent.on('widget:create',function (evt, widget) {
            visitorMap = new UserCountryMap.VisitorMap(config, widget);
        }).on('widget:maximise',function (evt) {
                    visitorMap.resize();
                }).on('widget:minimise',function (evt) {
                    visitorMap.resize();
                }).on('widget:destroy', function (evt) {
                    visitorMap.destroy();
                });
    } else {
        // stand-alone mode
        visitorMap = new UserCountryMap.VisitorMap(config);
    }

</script>
{% endif %}
", "@UserCountryMap/visitorMap.twig", "/var/www/html/plugins/UserCountryMap/templates/visitorMap.twig");
    }
}

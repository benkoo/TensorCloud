<?php

/* @Live/_visitorLogIcons.twig */
class __TwigTemplate_f690913798df6f26972f367755387bb1eecc38cf94484a860e0f279265c2a7f5 extends Twig_Template
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
        $context["visitHasEcommerceActivity"] = $this->getAttribute(($context["visitor"] ?? $this->getContext($context, "visitor")), "getColumn", array(0 => "visitEcommerceStatusIcon"), "method");
        // line 2
        $context["breakBeforeVisitorRank"] = (((($context["visitHasEcommerceActivity"] ?? $this->getContext($context, "visitHasEcommerceActivity")) && $this->getAttribute(($context["visitor"] ?? $this->getContext($context, "visitor")), "getColumn", array(0 => "visitorTypeIcon"), "method"))) ? (true) : (false));
        // line 3
        echo "
<span class=\"visitorLogIcons\">

    <span class=\"visitorDetails\">
    ";
        // line 7
        if ($this->getAttribute(($context["visitor"] ?? $this->getContext($context, "visitor")), "getColumn", array(0 => "visitorTypeIcon"), "method")) {
            // line 8
            echo "        <span class=\"visitorLogIconWithDetails visitorTypeIcon\">
            <img src=\"";
            // line 9
            echo \Piwik\piwik_escape_filter($this->env, $this->getAttribute(($context["visitor"] ?? $this->getContext($context, "visitor")), "getColumn", array(0 => "visitorTypeIcon"), "method"), "html", null, true);
            echo "\"/>
            <ul class=\"details\">
                <li>";
            // line 11
            echo \Piwik\piwik_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("General_ReturningVisitor")), "html", null, true);
            echo " - ";
            echo \Piwik\piwik_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("General_NVisits", $this->getAttribute(($context["visitor"] ?? $this->getContext($context, "visitor")), "getColumn", array(0 => "visitCount"), "method"))), "html", null, true);
            echo "</li>
            </ul>
        </span>
    ";
        }
        // line 15
        echo "    ";
        if ($this->getAttribute(($context["visitor"] ?? $this->getContext($context, "visitor")), "getColumn", array(0 => "countryFlag"), "method")) {
            // line 16
            echo "        <span class=\"visitorLogIconWithDetails flag\" profile-header-text=\"";
            if ($this->getAttribute(($context["visitor"] ?? $this->getContext($context, "visitor")), "getColumn", array(0 => "city"), "method")) {
                echo \Piwik\piwik_escape_filter($this->env, $this->getAttribute(($context["visitor"] ?? $this->getContext($context, "visitor")), "getColumn", array(0 => "city"), "method"), "html_attr");
            } else {
                echo \Piwik\piwik_escape_filter($this->env, $this->getAttribute(($context["visitor"] ?? $this->getContext($context, "visitor")), "getColumn", array(0 => "country"), "method"), "html", null, true);
            }
            echo "\">

            <img src=\"";
            // line 18
            echo \Piwik\piwik_escape_filter($this->env, $this->getAttribute(($context["visitor"] ?? $this->getContext($context, "visitor")), "getColumn", array(0 => "countryFlag"), "method"), "html", null, true);
            echo "\"/>
            <ul class=\"details\">
                <li>";
            // line 20
            echo \Piwik\piwik_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("UserCountry_Country")), "html", null, true);
            echo ": ";
            echo \Piwik\piwik_escape_filter($this->env, $this->getAttribute(($context["visitor"] ?? $this->getContext($context, "visitor")), "getColumn", array(0 => "country"), "method"), "html", null, true);
            echo "</li>
                ";
            // line 21
            if ($this->getAttribute(($context["visitor"] ?? $this->getContext($context, "visitor")), "getColumn", array(0 => "region"), "method")) {
                echo "<li>";
                echo \Piwik\piwik_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("UserCountry_Region")), "html", null, true);
                echo ": ";
                echo \Piwik\piwik_escape_filter($this->env, $this->getAttribute(($context["visitor"] ?? $this->getContext($context, "visitor")), "getColumn", array(0 => "region"), "method"), "html", null, true);
                echo "</li>";
            }
            // line 22
            echo "                ";
            if ($this->getAttribute(($context["visitor"] ?? $this->getContext($context, "visitor")), "getColumn", array(0 => "city"), "method")) {
                echo "<li>";
                echo \Piwik\piwik_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("UserCountry_City")), "html", null, true);
                echo ": ";
                echo \Piwik\piwik_escape_filter($this->env, $this->getAttribute(($context["visitor"] ?? $this->getContext($context, "visitor")), "getColumn", array(0 => "city"), "method"), "html", null, true);
                echo "</li>";
            }
            // line 23
            echo "                ";
            if ($this->getAttribute(($context["visitor"] ?? $this->getContext($context, "visitor")), "getColumn", array(0 => "language"), "method")) {
                echo "<li>";
                echo \Piwik\piwik_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("UserLanguage_BrowserLanguage")), "html", null, true);
                echo ": ";
                echo \Piwik\piwik_escape_filter($this->env, $this->getAttribute(($context["visitor"] ?? $this->getContext($context, "visitor")), "getColumn", array(0 => "language"), "method"), "html", null, true);
                echo "</li>";
            }
            // line 24
            echo "                ";
            if ($this->getAttribute(($context["visitor"] ?? $this->getContext($context, "visitor")), "getColumn", array(0 => "providerName"), "method")) {
                echo "<li>";
                echo \Piwik\piwik_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("Provider_ColumnProvider")), "html", null, true);
                echo ": ";
                echo \Piwik\piwik_escape_filter($this->env, $this->getAttribute(($context["visitor"] ?? $this->getContext($context, "visitor")), "getColumn", array(0 => "providerName"), "method"), "html", null, true);
                echo "</li>";
            }
            // line 25
            echo "                <li>";
            echo \Piwik\piwik_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("General_IP")), "html", null, true);
            echo ": ";
            echo \Piwik\piwik_escape_filter($this->env, $this->getAttribute(($context["visitor"] ?? $this->getContext($context, "visitor")), "getColumn", array(0 => "visitIp"), "method"), "html", null, true);
            echo "</li>
                ";
            // line 26
            if ( !twig_test_empty($this->getAttribute(($context["visitor"] ?? $this->getContext($context, "visitor")), "getColumn", array(0 => "visitorId"), "method"))) {
                echo "<li>";
                echo \Piwik\piwik_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("General_VisitorID")), "html", null, true);
                echo ": ";
                echo \Piwik\piwik_escape_filter($this->env, $this->getAttribute(($context["visitor"] ?? $this->getContext($context, "visitor")), "getColumn", array(0 => "visitorId"), "method"), "html", null, true);
                echo "</li>";
            }
            // line 27
            echo "
            </ul>
        </span>
    ";
        }
        // line 31
        echo "    ";
        if ($this->getAttribute(($context["visitor"] ?? $this->getContext($context, "visitor")), "getColumn", array(0 => "browserIcon"), "method")) {
            // line 32
            echo "        <span class=\"visitorLogIconWithDetails\" profile-header-text=\"";
            echo \Piwik\piwik_escape_filter($this->env, $this->getAttribute(($context["visitor"] ?? $this->getContext($context, "visitor")), "getColumn", array(0 => "browser"), "method"), "html_attr");
            echo "\">
            <img src=\"";
            // line 33
            echo \Piwik\piwik_escape_filter($this->env, $this->getAttribute(($context["visitor"] ?? $this->getContext($context, "visitor")), "getColumn", array(0 => "browserIcon"), "method"), "html", null, true);
            echo "\"/>
            <ul class=\"details\">
                <li>";
            // line 35
            echo \Piwik\piwik_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("DevicesDetection_ColumnBrowser")), "html", null, true);
            echo ": ";
            echo \Piwik\piwik_escape_filter($this->env, $this->getAttribute(($context["visitor"] ?? $this->getContext($context, "visitor")), "getColumn", array(0 => "browser"), "method"), "html", null, true);
            echo "</li>
                <li>";
            // line 36
            echo \Piwik\piwik_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("DevicesDetection_BrowserEngine")), "html", null, true);
            echo ": ";
            echo \Piwik\piwik_escape_filter($this->env, $this->getAttribute(($context["visitor"] ?? $this->getContext($context, "visitor")), "getColumn", array(0 => "browserFamily"), "method"), "html", null, true);
            echo "</li>
                ";
            // line 37
            if ((twig_length_filter($this->env, $this->getAttribute(($context["visitor"] ?? $this->getContext($context, "visitor")), "getColumn", array(0 => "pluginsIcons"), "method")) > 0)) {
                // line 38
                echo "                    <li>
                        ";
                // line 39
                echo \Piwik\piwik_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("General_Plugins")), "html", null, true);
                echo ":
                        ";
                // line 40
                $context['_parent'] = $context;
                $context['_seq'] = twig_ensure_traversable($this->getAttribute(($context["visitor"] ?? $this->getContext($context, "visitor")), "getColumn", array(0 => "pluginsIcons"), "method"));
                foreach ($context['_seq'] as $context["_key"] => $context["pluginIcon"]) {
                    // line 41
                    echo "                            <img width=\"16px\" height=\"16px\" src=\"";
                    echo \Piwik\piwik_escape_filter($this->env, $this->getAttribute($context["pluginIcon"], "pluginIcon", array()), "html", null, true);
                    echo "\" alt=\"";
                    echo \Piwik\piwik_escape_filter($this->env, twig_capitalize_string_filter($this->env, $this->getAttribute($context["pluginIcon"], "pluginName", array()), true), "html", null, true);
                    echo "\"/>
                        ";
                }
                $_parent = $context['_parent'];
                unset($context['_seq'], $context['_iterated'], $context['_key'], $context['pluginIcon'], $context['_parent'], $context['loop']);
                $context = array_intersect_key($context, $_parent) + $_parent;
                // line 43
                echo "                    </li>
                ";
            }
            // line 45
            echo "            </ul>
        </span>
    ";
        }
        // line 48
        echo "        ";
        if ($this->getAttribute(($context["visitor"] ?? $this->getContext($context, "visitor")), "getColumn", array(0 => "operatingSystemIcon"), "method")) {
            // line 49
            echo "            <span class=\"visitorLogIconWithDetails\" profile-header-text=\"";
            echo \Piwik\piwik_escape_filter($this->env, $this->getAttribute(($context["visitor"] ?? $this->getContext($context, "visitor")), "getColumn", array(0 => "operatingSystem"), "method"), "html_attr");
            echo "\">
            <img src=\"";
            // line 50
            echo \Piwik\piwik_escape_filter($this->env, $this->getAttribute(($context["visitor"] ?? $this->getContext($context, "visitor")), "getColumn", array(0 => "operatingSystemIcon"), "method"), "html", null, true);
            echo "\"/>
            <ul class=\"details\">
                <li>";
            // line 52
            echo \Piwik\piwik_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("DevicesDetection_ColumnOperatingSystem")), "html", null, true);
            echo ": ";
            echo \Piwik\piwik_escape_filter($this->env, $this->getAttribute(($context["visitor"] ?? $this->getContext($context, "visitor")), "getColumn", array(0 => "operatingSystem"), "method"), "html", null, true);
            echo "</li>
            </ul>
        </span>
        ";
        }
        // line 56
        echo "        ";
        if ($this->getAttribute(($context["visitor"] ?? $this->getContext($context, "visitor")), "getColumn", array(0 => "deviceTypeIcon"), "method")) {
            // line 57
            echo "            <span class=\"visitorLogIconWithDetails\" profile-header-text=\"";
            if ($this->getAttribute(($context["visitor"] ?? $this->getContext($context, "visitor")), "getColumn", array(0 => "resolution"), "method")) {
                echo \Piwik\piwik_escape_filter($this->env, $this->getAttribute(($context["visitor"] ?? $this->getContext($context, "visitor")), "getColumn", array(0 => "resolution"), "method"), "html_attr");
            } else {
                echo \Piwik\piwik_escape_filter($this->env, $this->getAttribute(($context["visitor"] ?? $this->getContext($context, "visitor")), "getColumn", array(0 => "deviceType"), "method"), "html", null, true);
            }
            echo "\">
            <img src=\"";
            // line 58
            echo \Piwik\piwik_escape_filter($this->env, $this->getAttribute(($context["visitor"] ?? $this->getContext($context, "visitor")), "getColumn", array(0 => "deviceTypeIcon"), "method"), "html", null, true);
            echo "\"/>
            <ul class=\"details\">
                <li>";
            // line 60
            echo \Piwik\piwik_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("DevicesDetection_DeviceType")), "html", null, true);
            echo ": ";
            echo \Piwik\piwik_escape_filter($this->env, $this->getAttribute(($context["visitor"] ?? $this->getContext($context, "visitor")), "getColumn", array(0 => "deviceType"), "method"), "html", null, true);
            echo "</li>
                ";
            // line 61
            if ($this->getAttribute(($context["visitor"] ?? $this->getContext($context, "visitor")), "getColumn", array(0 => "deviceBrand"), "method")) {
                echo "<li>";
                echo \Piwik\piwik_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("DevicesDetection_DeviceBrand")), "html", null, true);
                echo ": ";
                echo \Piwik\piwik_escape_filter($this->env, $this->getAttribute(($context["visitor"] ?? $this->getContext($context, "visitor")), "getColumn", array(0 => "deviceBrand"), "method"), "html", null, true);
                echo "</li>";
            }
            // line 62
            echo "                ";
            if ($this->getAttribute(($context["visitor"] ?? $this->getContext($context, "visitor")), "getColumn", array(0 => "deviceModel"), "method")) {
                echo "<li>";
                echo \Piwik\piwik_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("DevicesDetection_DeviceModel")), "html", null, true);
                echo ": ";
                echo \Piwik\piwik_escape_filter($this->env, $this->getAttribute(($context["visitor"] ?? $this->getContext($context, "visitor")), "getColumn", array(0 => "deviceModel"), "method"), "html", null, true);
                echo "</li>";
            }
            // line 63
            echo "                ";
            if ($this->getAttribute(($context["visitor"] ?? $this->getContext($context, "visitor")), "getColumn", array(0 => "resolution"), "method")) {
                echo "<li>";
                echo \Piwik\piwik_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("Resolution_ColumnResolution")), "html", null, true);
                echo ": ";
                echo \Piwik\piwik_escape_filter($this->env, $this->getAttribute(($context["visitor"] ?? $this->getContext($context, "visitor")), "getColumn", array(0 => "resolution"), "method"), "html", null, true);
                echo "</li>";
            }
            // line 64
            echo "            </ul>
        </span>
        ";
        }
        // line 67
        echo "    </span>

    ";
        // line 69
        if (($this->getAttribute(($context["visitor"] ?? $this->getContext($context, "visitor")), "getColumn", array(0 => "goalConversions"), "method") || ($context["visitHasEcommerceActivity"] ?? $this->getContext($context, "visitHasEcommerceActivity")))) {
            // line 70
            echo "    <span class=\"visitorType\">
        ";
            // line 72
            echo "        ";
            if ($this->getAttribute(($context["visitor"] ?? $this->getContext($context, "visitor")), "getColumn", array(0 => "goalConversions"), "method")) {
                // line 73
                echo "            <span title=\"";
                echo \Piwik\piwik_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("General_VisitConvertedNGoals", $this->getAttribute(($context["visitor"] ?? $this->getContext($context, "visitor")), "getColumn", array(0 => "goalConversions"), "method"))), "html", null, true);
                echo "\" class='visitorRank visitorLogTooltip'
                  ";
                // line 74
                if ((($context["isWidget"] ?? $this->getContext($context, "isWidget")) || ($context["breakBeforeVisitorRank"] ?? $this->getContext($context, "breakBeforeVisitorRank")))) {
                    echo "style=\"margin-left:0;\"";
                }
                echo ">
                <img src=\"";
                // line 75
                echo \Piwik\piwik_escape_filter($this->env, $this->getAttribute(($context["visitor"] ?? $this->getContext($context, "visitor")), "getColumn", array(0 => "visitConvertedIcon"), "method"), "html", null, true);
                echo "\"/>
                ";
                // line 76
                echo \Piwik\piwik_escape_filter($this->env, $this->getAttribute(($context["visitor"] ?? $this->getContext($context, "visitor")), "getColumn", array(0 => "goalConversions"), "method"), "html", null, true);
                echo "
                ";
                // line 77
                if (($context["visitHasEcommerceActivity"] ?? $this->getContext($context, "visitHasEcommerceActivity"))) {
                    // line 78
                    echo "                    &nbsp;
                    <img src=\"";
                    // line 79
                    echo \Piwik\piwik_escape_filter($this->env, $this->getAttribute(($context["visitor"] ?? $this->getContext($context, "visitor")), "getColumn", array(0 => "visitEcommerceStatusIcon"), "method"), "html", null, true);
                    echo "\" class='visitorLogTooltip' title=\"";
                    echo \Piwik\piwik_escape_filter($this->env, $this->getAttribute(($context["visitor"] ?? $this->getContext($context, "visitor")), "getColumn", array(0 => "visitEcommerceStatus"), "method"), "html", null, true);
                    echo "\"/>
                ";
                }
                // line 81
                echo "            </span>
        ";
                // line 83
                echo "        ";
            } elseif (($context["visitHasEcommerceActivity"] ?? $this->getContext($context, "visitHasEcommerceActivity"))) {
                // line 84
                echo "            <img class=\"visitorLogTooltip\" src=\"";
                echo \Piwik\piwik_escape_filter($this->env, $this->getAttribute(($context["visitor"] ?? $this->getContext($context, "visitor")), "getColumn", array(0 => "visitEcommerceStatusIcon"), "method"), "html", null, true);
                echo "\" title=\"";
                echo \Piwik\piwik_escape_filter($this->env, $this->getAttribute(($context["visitor"] ?? $this->getContext($context, "visitor")), "getColumn", array(0 => "visitEcommerceStatus"), "method"), "html", null, true);
                echo "\"/>
        ";
            }
            // line 86
            echo "    </span>
    ";
        }
        // line 88
        echo "</span>
";
    }

    public function getTemplateName()
    {
        return "@Live/_visitorLogIcons.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  323 => 88,  319 => 86,  311 => 84,  308 => 83,  305 => 81,  298 => 79,  295 => 78,  293 => 77,  289 => 76,  285 => 75,  279 => 74,  274 => 73,  271 => 72,  268 => 70,  266 => 69,  262 => 67,  257 => 64,  248 => 63,  239 => 62,  231 => 61,  225 => 60,  220 => 58,  211 => 57,  208 => 56,  199 => 52,  194 => 50,  189 => 49,  186 => 48,  181 => 45,  177 => 43,  166 => 41,  162 => 40,  158 => 39,  155 => 38,  153 => 37,  147 => 36,  141 => 35,  136 => 33,  131 => 32,  128 => 31,  122 => 27,  114 => 26,  107 => 25,  98 => 24,  89 => 23,  80 => 22,  72 => 21,  66 => 20,  61 => 18,  51 => 16,  48 => 15,  39 => 11,  34 => 9,  31 => 8,  29 => 7,  23 => 3,  21 => 2,  19 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("{% set visitHasEcommerceActivity = visitor.getColumn('visitEcommerceStatusIcon') %}
{% set breakBeforeVisitorRank = (visitHasEcommerceActivity and visitor.getColumn('visitorTypeIcon')) ? true : false %}

<span class=\"visitorLogIcons\">

    <span class=\"visitorDetails\">
    {% if visitor.getColumn('visitorTypeIcon') %}
        <span class=\"visitorLogIconWithDetails visitorTypeIcon\">
            <img src=\"{{ visitor.getColumn('visitorTypeIcon') }}\"/>
            <ul class=\"details\">
                <li>{{ 'General_ReturningVisitor'|translate }} - {{ 'General_NVisits'|translate(visitor.getColumn('visitCount')) }}</li>
            </ul>
        </span>
    {% endif %}
    {% if visitor.getColumn('countryFlag') %}
        <span class=\"visitorLogIconWithDetails flag\" profile-header-text=\"{% if visitor.getColumn('city') %}{{ visitor.getColumn('city')|e('html_attr') }}{% else %}{{ visitor.getColumn('country') }}{% endif %}\">

            <img src=\"{{ visitor.getColumn('countryFlag') }}\"/>
            <ul class=\"details\">
                <li>{{ 'UserCountry_Country'|translate }}: {{ visitor.getColumn('country') }}</li>
                {% if visitor.getColumn('region') %}<li>{{ 'UserCountry_Region'|translate }}: {{ visitor.getColumn('region') }}</li>{% endif %}
                {% if visitor.getColumn('city') %}<li>{{ 'UserCountry_City'|translate }}: {{ visitor.getColumn('city') }}</li>{% endif %}
                {% if visitor.getColumn('language') %}<li>{{ 'UserLanguage_BrowserLanguage'|translate }}: {{ visitor.getColumn('language') }}</li>{% endif %}
                {% if visitor.getColumn('providerName') %}<li>{{ 'Provider_ColumnProvider'|translate }}: {{ visitor.getColumn('providerName') }}</li>{% endif %}
                <li>{{ 'General_IP'|translate }}: {{ visitor.getColumn('visitIp') }}</li>
                {% if visitor.getColumn('visitorId') is not empty %}<li>{{ 'General_VisitorID'|translate }}: {{ visitor.getColumn('visitorId') }}</li>{% endif %}

            </ul>
        </span>
    {% endif %}
    {% if visitor.getColumn('browserIcon') %}
        <span class=\"visitorLogIconWithDetails\" profile-header-text=\"{{ visitor.getColumn('browser')|e('html_attr') }}\">
            <img src=\"{{ visitor.getColumn('browserIcon') }}\"/>
            <ul class=\"details\">
                <li>{{ 'DevicesDetection_ColumnBrowser'|translate }}: {{ visitor.getColumn('browser') }}</li>
                <li>{{ 'DevicesDetection_BrowserEngine'|translate }}: {{ visitor.getColumn('browserFamily') }}</li>
                {% if visitor.getColumn('pluginsIcons')|length > 0 %}
                    <li>
                        {{ 'General_Plugins'|translate }}:
                        {% for pluginIcon in visitor.getColumn('pluginsIcons') %}
                            <img width=\"16px\" height=\"16px\" src=\"{{ pluginIcon.pluginIcon }}\" alt=\"{{ pluginIcon.pluginName|capitalize(true) }}\"/>
                        {% endfor %}
                    </li>
                {% endif %}
            </ul>
        </span>
    {% endif %}
        {% if visitor.getColumn('operatingSystemIcon') %}
            <span class=\"visitorLogIconWithDetails\" profile-header-text=\"{{ visitor.getColumn('operatingSystem')|e('html_attr') }}\">
            <img src=\"{{ visitor.getColumn('operatingSystemIcon') }}\"/>
            <ul class=\"details\">
                <li>{{ 'DevicesDetection_ColumnOperatingSystem'|translate }}: {{ visitor.getColumn('operatingSystem') }}</li>
            </ul>
        </span>
        {% endif %}
        {% if visitor.getColumn('deviceTypeIcon') %}
            <span class=\"visitorLogIconWithDetails\" profile-header-text=\"{% if visitor.getColumn('resolution') %}{{ visitor.getColumn('resolution')|e('html_attr') }}{% else %}{{ visitor.getColumn('deviceType') }}{% endif %}\">
            <img src=\"{{ visitor.getColumn('deviceTypeIcon') }}\"/>
            <ul class=\"details\">
                <li>{{ 'DevicesDetection_DeviceType'|translate }}: {{ visitor.getColumn('deviceType') }}</li>
                {% if visitor.getColumn('deviceBrand') %}<li>{{ 'DevicesDetection_DeviceBrand'|translate }}: {{ visitor.getColumn('deviceBrand') }}</li>{% endif %}
                {% if visitor.getColumn('deviceModel') %}<li>{{ 'DevicesDetection_DeviceModel'|translate }}: {{ visitor.getColumn('deviceModel') }}</li>{% endif %}
                {% if visitor.getColumn('resolution') %}<li>{{ 'Resolution_ColumnResolution'|translate }}: {{ visitor.getColumn('resolution') }}</li>{% endif %}
            </ul>
        </span>
        {% endif %}
    </span>

    {% if visitor.getColumn('goalConversions') or visitHasEcommerceActivity %}
    <span class=\"visitorType\">
        {# Goals, and/or Ecommerce activity #}
        {% if visitor.getColumn('goalConversions') %}
            <span title=\"{{ 'General_VisitConvertedNGoals'|translate(visitor.getColumn('goalConversions')) }}\" class='visitorRank visitorLogTooltip'
                  {% if isWidget or breakBeforeVisitorRank %}style=\"margin-left:0;\"{% endif %}>
                <img src=\"{{ visitor.getColumn('visitConvertedIcon') }}\"/>
                {{ visitor.getColumn('goalConversions') }}
                {% if visitHasEcommerceActivity %}
                    &nbsp;
                    <img src=\"{{ visitor.getColumn('visitEcommerceStatusIcon') }}\" class='visitorLogTooltip' title=\"{{ visitor.getColumn('visitEcommerceStatus') }}\"/>
                {% endif %}
            </span>
        {# Ecommerce activity only (no goal) #}
        {% elseif visitHasEcommerceActivity %}
            <img class=\"visitorLogTooltip\" src=\"{{ visitor.getColumn('visitEcommerceStatusIcon') }}\" title=\"{{ visitor.getColumn('visitEcommerceStatus') }}\"/>
        {% endif %}
    </span>
    {% endif %}
</span>
", "@Live/_visitorLogIcons.twig", "/var/www/html/plugins/Live/templates/_visitorLogIcons.twig");
    }
}

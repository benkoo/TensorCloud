<?php

/* @Dashboard/embeddedIndex.twig */
class __TwigTemplate_4faf4e664736ed58fb809c3761da78d91818ee7faa964168cc3b43f3baad328d extends Twig_Template
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
        echo "<div id=\"dashboard\" piwik-dashboard dashboardid=\"";
        echo \Piwik\piwik_escape_filter($this->env, ($context["dashboardId"] ?? $this->getContext($context, "dashboardId")), "html", null, true);
        echo "\">
    <div class=\"ui-confirm\" id=\"confirm\">
        <h2>";
        // line 3
        echo \Piwik\piwik_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("Dashboard_DeleteWidgetConfirm")), "html", null, true);
        echo "</h2>
        <input role=\"yes\" type=\"button\" value=\"";
        // line 4
        echo \Piwik\piwik_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("General_Yes")), "html", null, true);
        echo "\"/>
        <input role=\"no\" type=\"button\" value=\"";
        // line 5
        echo \Piwik\piwik_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("General_No")), "html", null, true);
        echo "\"/>
    </div>

    <div class=\"ui-confirm\" id=\"setAsDefaultWidgetsConfirm\">
        <h2>";
        // line 9
        echo \Piwik\piwik_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("Dashboard_SetAsDefaultWidgetsConfirm")), "html", null, true);
        echo "</h2>
        ";
        // line 10
        ob_start();
        echo \Piwik\piwik_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("Dashboard_ResetDashboard")), "html", null, true);
        $context["resetDashboard"] = ('' === $tmp = ob_get_clean()) ? '' : new Twig_Markup($tmp, $this->env->getCharset());
        // line 11
        echo "        <div class=\"popoverSubMessage\">";
        echo \Piwik\piwik_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("Dashboard_SetAsDefaultWidgetsConfirmHelp", ($context["resetDashboard"] ?? $this->getContext($context, "resetDashboard")))), "html", null, true);
        echo "</div>
        <input role=\"yes\" type=\"button\" value=\"";
        // line 12
        echo \Piwik\piwik_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("General_Yes")), "html", null, true);
        echo "\"/>
        <input role=\"no\" type=\"button\" value=\"";
        // line 13
        echo \Piwik\piwik_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("General_No")), "html", null, true);
        echo "\"/>
    </div>

    <div class=\"ui-confirm\" id=\"resetDashboardConfirm\">
        <h2>";
        // line 17
        echo \Piwik\piwik_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("Dashboard_ResetDashboardConfirm")), "html", null, true);
        echo "</h2>
        <input role=\"yes\" type=\"button\" value=\"";
        // line 18
        echo \Piwik\piwik_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("General_Yes")), "html", null, true);
        echo "\"/>
        <input role=\"no\" type=\"button\" value=\"";
        // line 19
        echo \Piwik\piwik_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("General_No")), "html", null, true);
        echo "\"/>
    </div>

    <div class=\"ui-confirm\" id=\"dashboardEmptyNotification\">
        <h2>";
        // line 23
        echo \Piwik\piwik_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("Dashboard_DashboardEmptyNotification")), "html", null, true);
        echo "</h2>
        <input role=\"addWidget\" type=\"button\" value=\"";
        // line 24
        echo \Piwik\piwik_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("Dashboard_AddAWidget")), "html", null, true);
        echo "\"/>
        <input role=\"resetDashboard\" type=\"button\" value=\"";
        // line 25
        echo \Piwik\piwik_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("Dashboard_ResetDashboard")), "html", null, true);
        echo "\"/>
    </div>

    <div class=\"ui-confirm\" id=\"changeDashboardLayout\">
        <h2>";
        // line 29
        echo \Piwik\piwik_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("Dashboard_SelectDashboardLayout")), "html", null, true);
        echo "</h2>

        <div id=\"columnPreview\">
            ";
        // line 32
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["availableLayouts"] ?? $this->getContext($context, "availableLayouts")));
        foreach ($context['_seq'] as $context["_key"] => $context["layout"]) {
            // line 33
            echo "            <div>
                ";
            // line 34
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable($context["layout"]);
            foreach ($context['_seq'] as $context["_key"] => $context["column"]) {
                // line 35
                echo "                <div class=\"width-";
                echo \Piwik\piwik_escape_filter($this->env, $context["column"], "html", null, true);
                echo "\"><span></span></div>
                ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['column'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 37
            echo "            </div>
            ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['layout'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 39
        echo "            <br class=\"clearfix\" />
        </div>
        <input role=\"yes\" type=\"button\" value=\"";
        // line 41
        echo \Piwik\piwik_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("General_Save")), "html", null, true);
        echo "\"/>
        <input role=\"cancel\" type=\"button\" value=\"";
        // line 42
        echo \Piwik\piwik_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("General_Cancel")), "html", null, true);
        echo "\"/>
    </div>

    <div class=\"ui-confirm\" id=\"renameDashboardConfirm\">
        <h2>";
        // line 46
        echo \Piwik\piwik_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("Dashboard_RenameDashboard")), "html", null, true);
        echo "</h2>

        <div id=\"newDashboardNameInput\">
            <label for=\"newDashboardName\">";
        // line 49
        echo \Piwik\piwik_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("Dashboard_DashboardName")), "html", null, true);
        echo " </label>
            <input type=\"text\" name=\"newDashboardName\" id=\"newDashboardName\" value=\"\"/>
        </div>
        <input role=\"yes\" type=\"button\" value=\"";
        // line 52
        echo \Piwik\piwik_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("General_Save")), "html", null, true);
        echo "\"/>
        <input role=\"cancel\" type=\"button\" value=\"";
        // line 53
        echo \Piwik\piwik_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("General_Cancel")), "html", null, true);
        echo "\"/>
    </div>

    ";
        // line 56
        if (($context["isSuperUser"] ?? $this->getContext($context, "isSuperUser"))) {
            // line 57
            echo "        <div class=\"ui-confirm\" id=\"copyDashboardToUserConfirm\">
            <h2>";
            // line 58
            echo \Piwik\piwik_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("Dashboard_CopyDashboardToUser")), "html", null, true);
            echo "</h2>

            <div class=\"inputs\">
                <div class=\"row\">
                    <div class=\"col s12 m6\"><label for=\"copyDashboardName\">";
            // line 62
            echo \Piwik\piwik_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("Dashboard_DashboardName")), "html", null, true);
            echo " </label></div>
                    <div class=\"col s12 m6\"><input type=\"text\" name=\"copyDashboardName\" id=\"copyDashboardName\" value=\"\"/></div>
                </div>
                <div class=\"row\">
                    <div class=\"col s12 m6\"><label for=\"copyDashboardUser\">";
            // line 66
            echo \Piwik\piwik_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("General_Username")), "html", null, true);
            echo " </label></div>
                    <div class=\"col s12 m6\"><select class=\"browser-default\" name=\"copyDashboardUser\" id=\"copyDashboardUser\"></select></div>
                </div>
            </div>

            <input role=\"yes\" type=\"button\" value=\"";
            // line 71
            echo \Piwik\piwik_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("General_Ok")), "html", null, true);
            echo "\"/>
            <input role=\"cancel\" type=\"button\" value=\"";
            // line 72
            echo \Piwik\piwik_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("General_Cancel")), "html", null, true);
            echo "\"/>
        </div>
    ";
        }
        // line 75
        echo "
    <div class=\"ui-confirm\" id=\"createDashboardConfirm\">
        <h2>";
        // line 77
        echo \Piwik\piwik_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("Dashboard_CreateNewDashboard")), "html", null, true);
        echo "</h2>

        <div id=\"createDashboardNameInput\">
            <p>
                <label>";
        // line 81
        echo \Piwik\piwik_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("Dashboard_DashboardName")), "html", null, true);
        echo " </label>
                <input type=\"text\" name=\"newDashboardName\" id=\"createDashboardName\" value=\"\"/>
            </p>
            <p>
                <input type=\"radio\" checked=\"checked\" name=\"type\" value=\"default\" id=\"dashboard_type_default\" />
                <label for=\"dashboard_type_default\">";
        // line 86
        echo \Piwik\piwik_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("Dashboard_DefaultDashboard")), "html", null, true);
        echo "</label>
            </p>
            <p>
                <input type=\"radio\" name=\"type\" value=\"empty\" id=\"dashboard_type_empty\" />
                <label for=\"dashboard_type_empty\">";
        // line 90
        echo \Piwik\piwik_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("Dashboard_EmptyDashboard")), "html", null, true);
        echo "</label>
            </p>

        </div>
        <input role=\"yes\" type=\"button\" value=\"";
        // line 94
        echo \Piwik\piwik_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("General_Ok")), "html", null, true);
        echo "\"/>
        <input role=\"no\" type=\"button\" value=\"";
        // line 95
        echo \Piwik\piwik_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("General_Cancel")), "html", null, true);
        echo "\"/>
    </div>

    <div class=\"ui-confirm\" id=\"removeDashboardConfirm\">
        <h2>";
        // line 99
        echo call_user_func_array($this->env->getFilter('translate')->getCallable(), array("Dashboard_RemoveDashboardConfirm", "<span></span>"));
        echo "</h2>

        <div class=\"popoverSubMessage\">";
        // line 101
        echo \Piwik\piwik_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("Dashboard_NotUndo", ($context["resetDashboard"] ?? $this->getContext($context, "resetDashboard")))), "html", null, true);
        echo "</div>
        <input role=\"yes\" type=\"button\" value=\"";
        // line 102
        echo \Piwik\piwik_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("General_Yes")), "html", null, true);
        echo "\"/>
        <input role=\"no\" type=\"button\" value=\"";
        // line 103
        echo \Piwik\piwik_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("General_No")), "html", null, true);
        echo "\"/>
    </div>

    ";
        // line 106
        $this->loadTemplate("@Dashboard/_widgetFactoryTemplate.twig", "@Dashboard/embeddedIndex.twig", 106)->display($context);
        // line 107
        echo "
    <div id=\"dashboardWidgetsArea\" class=\"row\"></div>
</div>
";
    }

    public function getTemplateName()
    {
        return "@Dashboard/embeddedIndex.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  266 => 107,  264 => 106,  258 => 103,  254 => 102,  250 => 101,  245 => 99,  238 => 95,  234 => 94,  227 => 90,  220 => 86,  212 => 81,  205 => 77,  201 => 75,  195 => 72,  191 => 71,  183 => 66,  176 => 62,  169 => 58,  166 => 57,  164 => 56,  158 => 53,  154 => 52,  148 => 49,  142 => 46,  135 => 42,  131 => 41,  127 => 39,  120 => 37,  111 => 35,  107 => 34,  104 => 33,  100 => 32,  94 => 29,  87 => 25,  83 => 24,  79 => 23,  72 => 19,  68 => 18,  64 => 17,  57 => 13,  53 => 12,  48 => 11,  44 => 10,  40 => 9,  33 => 5,  29 => 4,  25 => 3,  19 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("<div id=\"dashboard\" piwik-dashboard dashboardid=\"{{ dashboardId }}\">
    <div class=\"ui-confirm\" id=\"confirm\">
        <h2>{{ 'Dashboard_DeleteWidgetConfirm'|translate }}</h2>
        <input role=\"yes\" type=\"button\" value=\"{{ 'General_Yes'|translate }}\"/>
        <input role=\"no\" type=\"button\" value=\"{{ 'General_No'|translate }}\"/>
    </div>

    <div class=\"ui-confirm\" id=\"setAsDefaultWidgetsConfirm\">
        <h2>{{ 'Dashboard_SetAsDefaultWidgetsConfirm'|translate }}</h2>
        {% set resetDashboard %}{{ 'Dashboard_ResetDashboard'|translate }}{% endset %}
        <div class=\"popoverSubMessage\">{{ 'Dashboard_SetAsDefaultWidgetsConfirmHelp'|translate(resetDashboard) }}</div>
        <input role=\"yes\" type=\"button\" value=\"{{ 'General_Yes'|translate }}\"/>
        <input role=\"no\" type=\"button\" value=\"{{ 'General_No'|translate }}\"/>
    </div>

    <div class=\"ui-confirm\" id=\"resetDashboardConfirm\">
        <h2>{{ 'Dashboard_ResetDashboardConfirm'|translate }}</h2>
        <input role=\"yes\" type=\"button\" value=\"{{ 'General_Yes'|translate }}\"/>
        <input role=\"no\" type=\"button\" value=\"{{ 'General_No'|translate }}\"/>
    </div>

    <div class=\"ui-confirm\" id=\"dashboardEmptyNotification\">
        <h2>{{ 'Dashboard_DashboardEmptyNotification'|translate }}</h2>
        <input role=\"addWidget\" type=\"button\" value=\"{{ 'Dashboard_AddAWidget'|translate }}\"/>
        <input role=\"resetDashboard\" type=\"button\" value=\"{{ 'Dashboard_ResetDashboard'|translate }}\"/>
    </div>

    <div class=\"ui-confirm\" id=\"changeDashboardLayout\">
        <h2>{{ 'Dashboard_SelectDashboardLayout'|translate }}</h2>

        <div id=\"columnPreview\">
            {% for layout in availableLayouts %}
            <div>
                {% for column in layout %}
                <div class=\"width-{{ column }}\"><span></span></div>
                {% endfor %}
            </div>
            {% endfor %}
            <br class=\"clearfix\" />
        </div>
        <input role=\"yes\" type=\"button\" value=\"{{ 'General_Save'|translate }}\"/>
        <input role=\"cancel\" type=\"button\" value=\"{{ 'General_Cancel'|translate }}\"/>
    </div>

    <div class=\"ui-confirm\" id=\"renameDashboardConfirm\">
        <h2>{{ 'Dashboard_RenameDashboard'|translate }}</h2>

        <div id=\"newDashboardNameInput\">
            <label for=\"newDashboardName\">{{ 'Dashboard_DashboardName'|translate }} </label>
            <input type=\"text\" name=\"newDashboardName\" id=\"newDashboardName\" value=\"\"/>
        </div>
        <input role=\"yes\" type=\"button\" value=\"{{ 'General_Save'|translate }}\"/>
        <input role=\"cancel\" type=\"button\" value=\"{{ 'General_Cancel'|translate }}\"/>
    </div>

    {% if isSuperUser %}
        <div class=\"ui-confirm\" id=\"copyDashboardToUserConfirm\">
            <h2>{{ 'Dashboard_CopyDashboardToUser'|translate }}</h2>

            <div class=\"inputs\">
                <div class=\"row\">
                    <div class=\"col s12 m6\"><label for=\"copyDashboardName\">{{ 'Dashboard_DashboardName'|translate }} </label></div>
                    <div class=\"col s12 m6\"><input type=\"text\" name=\"copyDashboardName\" id=\"copyDashboardName\" value=\"\"/></div>
                </div>
                <div class=\"row\">
                    <div class=\"col s12 m6\"><label for=\"copyDashboardUser\">{{ 'General_Username'|translate }} </label></div>
                    <div class=\"col s12 m6\"><select class=\"browser-default\" name=\"copyDashboardUser\" id=\"copyDashboardUser\"></select></div>
                </div>
            </div>

            <input role=\"yes\" type=\"button\" value=\"{{ 'General_Ok'|translate }}\"/>
            <input role=\"cancel\" type=\"button\" value=\"{{ 'General_Cancel'|translate }}\"/>
        </div>
    {% endif %}

    <div class=\"ui-confirm\" id=\"createDashboardConfirm\">
        <h2>{{ 'Dashboard_CreateNewDashboard'|translate }}</h2>

        <div id=\"createDashboardNameInput\">
            <p>
                <label>{{ 'Dashboard_DashboardName'|translate }} </label>
                <input type=\"text\" name=\"newDashboardName\" id=\"createDashboardName\" value=\"\"/>
            </p>
            <p>
                <input type=\"radio\" checked=\"checked\" name=\"type\" value=\"default\" id=\"dashboard_type_default\" />
                <label for=\"dashboard_type_default\">{{ 'Dashboard_DefaultDashboard'|translate }}</label>
            </p>
            <p>
                <input type=\"radio\" name=\"type\" value=\"empty\" id=\"dashboard_type_empty\" />
                <label for=\"dashboard_type_empty\">{{ 'Dashboard_EmptyDashboard'|translate }}</label>
            </p>

        </div>
        <input role=\"yes\" type=\"button\" value=\"{{ 'General_Ok'|translate }}\"/>
        <input role=\"no\" type=\"button\" value=\"{{ 'General_Cancel'|translate }}\"/>
    </div>

    <div class=\"ui-confirm\" id=\"removeDashboardConfirm\">
        <h2>{{ 'Dashboard_RemoveDashboardConfirm'|translate('<span></span>')|raw }}</h2>

        <div class=\"popoverSubMessage\">{{ 'Dashboard_NotUndo'|translate(resetDashboard) }}</div>
        <input role=\"yes\" type=\"button\" value=\"{{ 'General_Yes'|translate }}\"/>
        <input role=\"no\" type=\"button\" value=\"{{ 'General_No'|translate }}\"/>
    </div>

    {% include \"@Dashboard/_widgetFactoryTemplate.twig\" %}

    <div id=\"dashboardWidgetsArea\" class=\"row\"></div>
</div>
", "@Dashboard/embeddedIndex.twig", "/var/www/html/plugins/Dashboard/templates/embeddedIndex.twig");
    }
}

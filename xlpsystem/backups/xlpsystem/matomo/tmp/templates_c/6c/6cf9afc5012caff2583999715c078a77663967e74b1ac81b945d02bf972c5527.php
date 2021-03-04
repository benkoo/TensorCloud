<?php

/* dashboard.twig */
class __TwigTemplate_f6f65f66243a537f2e522fd07ce2f8347fdd9745de36e8c2b4658b9b3cdefc5c extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 1
        $this->parent = $this->loadTemplate("layout.twig", "dashboard.twig", 1);
        $this->blocks = array(
            'head' => array($this, 'block_head'),
            'pageDescription' => array($this, 'block_pageDescription'),
            'body' => array($this, 'block_body'),
            'root' => array($this, 'block_root'),
            'topcontrols' => array($this, 'block_topcontrols'),
            'notification' => array($this, 'block_notification'),
            'content' => array($this, 'block_content'),
        );
    }

    protected function doGetParent(array $context)
    {
        return "layout.twig";
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 11
        ob_start();
        echo ($context["siteName"] ?? $this->getContext($context, "siteName"));
        if (array_key_exists("prettyDateLong", $context)) {
            echo " - ";
            echo \Piwik\piwik_escape_filter($this->env, ($context["prettyDateLong"] ?? $this->getContext($context, "prettyDateLong")), "html", null, true);
        }
        echo " - ";
        echo \Piwik\piwik_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("CoreHome_WebAnalyticsReports")), "html", null, true);
        $context["title"] = ('' === $tmp = ob_get_clean()) ? '' : new Twig_Markup($tmp, $this->env->getCharset());
        // line 15
        $context["bodyClass"] = call_user_func_array($this->env->getFunction('postEvent')->getCallable(), array("Template.bodyClass", "dashboard"));
        // line 1
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 3
    public function block_head($context, array $blocks = array())
    {
        // line 4
        echo "    ";
        $this->displayParentBlock("head", $context, $blocks);
        echo "

    <!--[if lt IE 9]>
    <script language=\"javascript\" type=\"text/javascript\" src=\"libs/jqplot/excanvas.min.js\"></script>
    <![endif]-->
";
    }

    // line 13
    public function block_pageDescription($context, array $blocks = array())
    {
        echo "Web Analytics report for ";
        echo \Piwik\piwik_escape_filter($this->env, ($context["siteName"] ?? $this->getContext($context, "siteName")), "html_attr");
        echo " - Matomo";
    }

    // line 17
    public function block_body($context, array $blocks = array())
    {
        // line 18
        echo "    ";
        echo call_user_func_array($this->env->getFunction('postEvent')->getCallable(), array("Template.header", "dashboard"));
        echo "
    ";
        // line 19
        $this->displayParentBlock("body", $context, $blocks);
        echo "
    ";
        // line 20
        echo call_user_func_array($this->env->getFunction('postEvent')->getCallable(), array("Template.footer", "dashboard"));
        echo "
";
    }

    // line 23
    public function block_root($context, array $blocks = array())
    {
        // line 24
        echo "    ";
        $this->loadTemplate("@CoreHome/_warningInvalidHost.twig", "dashboard.twig", 24)->display($context);
        // line 25
        echo "    ";
        $this->loadTemplate("@CoreHome/_topScreen.twig", "dashboard.twig", 25)->display($context);
        // line 26
        echo "
    <div class=\"top_controls\">
        <div piwik-quick-access ng-cloak class=\"piwikTopControl borderedControl\"></div>
        ";
        // line 29
        $this->displayBlock('topcontrols', $context, $blocks);
        // line 31
        echo "
    </div>

    <div class=\"ui-confirm\" id=\"alert\">
        <h2></h2>
        <input role=\"yes\" type=\"button\" value=\"";
        // line 36
        echo \Piwik\piwik_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("General_Ok")), "html", null, true);
        echo "\"/>
    </div>

    ";
        // line 39
        echo call_user_func_array($this->env->getFunction('postEvent')->getCallable(), array("Template.beforeContent", "dashboard", ($context["currentModule"] ?? $this->getContext($context, "currentModule")), ($context["currentAction"] ?? $this->getContext($context, "currentAction"))));
        echo "

    <div class=\"page\">

        ";
        // line 43
        if ((array_key_exists("showMenu", $context) && ($context["showMenu"] ?? $this->getContext($context, "showMenu")))) {
            // line 44
            echo "            <div id=\"secondNavBar\" class=\"Menu--dashboard z-depth-1\">
                <div piwik-reporting-menu></div>
            </div>
        ";
        }
        // line 48
        echo "
        <div class=\"pageWrap\" ng-cloak>

            <a name=\"main\"></a>
            ";
        // line 52
        $this->displayBlock('notification', $context, $blocks);
        // line 55
        echo "
            <div piwik-popover></div>

            ";
        // line 58
        $this->displayBlock('content', $context, $blocks);
        // line 60
        echo "
            <div class=\"clear\"></div>
        </div>

    </div>
";
    }

    // line 29
    public function block_topcontrols($context, array $blocks = array())
    {
        // line 30
        echo "        ";
    }

    // line 52
    public function block_notification($context, array $blocks = array())
    {
        // line 53
        echo "                ";
        $this->loadTemplate("@CoreHome/_notifications.twig", "dashboard.twig", 53)->display($context);
        // line 54
        echo "            ";
    }

    // line 58
    public function block_content($context, array $blocks = array())
    {
        // line 59
        echo "            ";
    }

    public function getTemplateName()
    {
        return "dashboard.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  175 => 59,  172 => 58,  168 => 54,  165 => 53,  162 => 52,  158 => 30,  155 => 29,  146 => 60,  144 => 58,  139 => 55,  137 => 52,  131 => 48,  125 => 44,  123 => 43,  116 => 39,  110 => 36,  103 => 31,  101 => 29,  96 => 26,  93 => 25,  90 => 24,  87 => 23,  81 => 20,  77 => 19,  72 => 18,  69 => 17,  61 => 13,  50 => 4,  47 => 3,  43 => 1,  41 => 15,  31 => 11,  11 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("{% extends 'layout.twig' %}

{% block head %}
    {{ parent() }}

    <!--[if lt IE 9]>
    <script language=\"javascript\" type=\"text/javascript\" src=\"libs/jqplot/excanvas.min.js\"></script>
    <![endif]-->
{% endblock %}

{% set title %}{{ siteName|raw }}{% if prettyDateLong is defined %} - {{ prettyDateLong }}{% endif %} - {{ 'CoreHome_WebAnalyticsReports'|translate }}{% endset %}

{% block pageDescription %}Web Analytics report for {{ siteName|escape(\"html_attr\") }} - Matomo{% endblock %}

{% set bodyClass = postEvent('Template.bodyClass', 'dashboard') %}

{% block body %}
    {{ postEvent(\"Template.header\", \"dashboard\") }}
    {{ parent() }}
    {{ postEvent(\"Template.footer\", \"dashboard\") }}
{% endblock %}

{% block root %}
    {% include \"@CoreHome/_warningInvalidHost.twig\" %}
    {% include \"@CoreHome/_topScreen.twig\" %}

    <div class=\"top_controls\">
        <div piwik-quick-access ng-cloak class=\"piwikTopControl borderedControl\"></div>
        {% block topcontrols %}
        {% endblock %}

    </div>

    <div class=\"ui-confirm\" id=\"alert\">
        <h2></h2>
        <input role=\"yes\" type=\"button\" value=\"{{ 'General_Ok'|translate }}\"/>
    </div>

    {{ postEvent(\"Template.beforeContent\", \"dashboard\", currentModule, currentAction) }}

    <div class=\"page\">

        {% if showMenu is defined and showMenu %}
            <div id=\"secondNavBar\" class=\"Menu--dashboard z-depth-1\">
                <div piwik-reporting-menu></div>
            </div>
        {% endif %}

        <div class=\"pageWrap\" ng-cloak>

            <a name=\"main\"></a>
            {% block notification %}
                {% include \"@CoreHome/_notifications.twig\" %}
            {% endblock %}

            <div piwik-popover></div>

            {% block content %}
            {% endblock %}

            <div class=\"clear\"></div>
        </div>

    </div>
{% endblock %}
", "dashboard.twig", "/var/www/html/plugins/Morpheus/templates/dashboard.twig");
    }
}

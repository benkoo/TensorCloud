<?php

/* @Installation/firstWebsiteSetup.twig */
class __TwigTemplate_c5787b56af979c7867c0d03273bf79d9e8240aa32e137a9aeb824a83c211e78d extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 1
        $this->parent = $this->loadTemplate("@Installation/layout.twig", "@Installation/firstWebsiteSetup.twig", 1);
        $this->blocks = array(
            'content' => array($this, 'block_content'),
        );
    }

    protected function doGetParent(array $context)
    {
        return "@Installation/layout.twig";
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 3
    public function block_content($context, array $blocks = array())
    {
        // line 4
        echo "
    <h2>";
        // line 5
        echo \Piwik\piwik_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("Installation_SetupWebsite")), "html", null, true);
        echo "</h2>

    ";
        // line 7
        if (array_key_exists("displayGeneralSetupSuccess", $context)) {
            // line 8
            echo "        <div id=\"feedback\" class=\"alert alert-success\">
            ";
            // line 9
            echo \Piwik\piwik_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("Installation_SuperUserSetupSuccess")), "html", null, true);
            echo "
        </div>
    ";
        }
        // line 12
        echo "
    <p>";
        // line 13
        echo \Piwik\piwik_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("Installation_SiteSetup")), "html", null, true);
        echo "</p>

    ";
        // line 15
        if (array_key_exists("errorMessage", $context)) {
            // line 16
            echo "        <div class=\"alert alert-danger\">
            ";
            // line 17
            echo \Piwik\piwik_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("Installation_SetupWebsiteError")), "html", null, true);
            echo ":
            <br/>- ";
            // line 18
            echo ($context["errorMessage"] ?? $this->getContext($context, "errorMessage"));
            echo "
        </div>
    ";
        }
        // line 21
        echo "
    ";
        // line 22
        if (array_key_exists("form_data", $context)) {
            // line 23
            echo "        ";
            $this->loadTemplate("genericForm.twig", "@Installation/firstWebsiteSetup.twig", 23)->display($context);
            // line 24
            echo "    ";
        }
        // line 25
        echo "    <div class=\"clearfix\"></div>

    <p><em>";
        // line 27
        echo \Piwik\piwik_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("Installation_SiteSetupFootnote")), "html", null, true);
        echo "</em></p>

";
    }

    public function getTemplateName()
    {
        return "@Installation/firstWebsiteSetup.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  88 => 27,  84 => 25,  81 => 24,  78 => 23,  76 => 22,  73 => 21,  67 => 18,  63 => 17,  60 => 16,  58 => 15,  53 => 13,  50 => 12,  44 => 9,  41 => 8,  39 => 7,  34 => 5,  31 => 4,  28 => 3,  11 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("{% extends '@Installation/layout.twig' %}

{% block content %}

    <h2>{{ 'Installation_SetupWebsite'|translate }}</h2>

    {% if displayGeneralSetupSuccess is defined %}
        <div id=\"feedback\" class=\"alert alert-success\">
            {{ 'Installation_SuperUserSetupSuccess'|translate }}
        </div>
    {% endif %}

    <p>{{ 'Installation_SiteSetup'|translate }}</p>

    {% if errorMessage is defined %}
        <div class=\"alert alert-danger\">
            {{ 'Installation_SetupWebsiteError'|translate }}:
            <br/>- {{ errorMessage|raw }}
        </div>
    {% endif %}

    {% if form_data is defined %}
        {% include \"genericForm.twig\" %}
    {% endif %}
    <div class=\"clearfix\"></div>

    <p><em>{{ 'Installation_SiteSetupFootnote'|translate }}</em></p>

{% endblock %}
", "@Installation/firstWebsiteSetup.twig", "/var/www/html/plugins/Installation/templates/firstWebsiteSetup.twig");
    }
}

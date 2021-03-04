<?php

/* @Installation/setupSuperUser.twig */
class __TwigTemplate_5f8c9bd8db071b6320b7aa29d12dbd1823307bf4268b45cc798b4c579b3937ff extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 1
        $this->parent = $this->loadTemplate("@Installation/layout.twig", "@Installation/setupSuperUser.twig", 1);
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
        echo \Piwik\piwik_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("Installation_SuperUser")), "html", null, true);
        echo "</h2>

    ";
        // line 7
        if (array_key_exists("errorMessage", $context)) {
            // line 8
            echo "        <div class=\"alert alert-danger\">
            ";
            // line 9
            echo \Piwik\piwik_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("Installation_SuperUserSetupError")), "html", null, true);
            echo ":
            <br/>- ";
            // line 10
            echo ($context["errorMessage"] ?? $this->getContext($context, "errorMessage"));
            echo "
        </div>
    ";
        }
        // line 13
        echo "
    ";
        // line 14
        if (array_key_exists("form_data", $context)) {
            // line 15
            echo "        ";
            $this->loadTemplate("genericForm.twig", "@Installation/setupSuperUser.twig", 15)->display($context);
            // line 16
            echo "    ";
        }
        // line 17
        echo "
";
    }

    public function getTemplateName()
    {
        return "@Installation/setupSuperUser.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  65 => 17,  62 => 16,  59 => 15,  57 => 14,  54 => 13,  48 => 10,  44 => 9,  41 => 8,  39 => 7,  34 => 5,  31 => 4,  28 => 3,  11 => 1,);
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

    <h2>{{ 'Installation_SuperUser'|translate }}</h2>

    {% if errorMessage is defined %}
        <div class=\"alert alert-danger\">
            {{ 'Installation_SuperUserSetupError'|translate }}:
            <br/>- {{ errorMessage|raw }}
        </div>
    {% endif %}

    {% if form_data is defined %}
        {% include \"genericForm.twig\" %}
    {% endif %}

{% endblock %}
", "@Installation/setupSuperUser.twig", "/var/www/html/plugins/Installation/templates/setupSuperUser.twig");
    }
}

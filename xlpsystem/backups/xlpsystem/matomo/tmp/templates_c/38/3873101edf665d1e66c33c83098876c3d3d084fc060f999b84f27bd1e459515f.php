<?php

/* contentBlock.twig */
class __TwigTemplate_7daedd8cf068a1b46f278a13e22b78f0d380b6283bf2413003c44d010083d496 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
            'helpText' => array($this, 'block_helpText'),
            'content' => array($this, 'block_content'),
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        echo "<div class=\"card\">
    <div class=\"card-content\">
        ";
        // line 3
        if ((array_key_exists("title", $context) && ($context["title"] ?? $this->getContext($context, "title")))) {
            // line 4
            echo "            <h2 class=\"card-title\"
                  ";
            // line 5
            if (((array_key_exists("rate", $context) && ($context["rate"] ?? $this->getContext($context, "rate"))) && call_user_func_array($this->env->getTest('true')->getCallable(), array(($context["rate"] ?? $this->getContext($context, "rate")))))) {
                echo "piwik-enriched-headline=\"";
                echo \Piwik\piwik_escape_filter($this->env, ($context["title"] ?? $this->getContext($context, "title")), "html_attr");
                echo "\"
                  ";
            } elseif (((            // line 6
array_key_exists("rate", $context) && ($context["rate"] ?? $this->getContext($context, "rate"))) && ($context["rate"] ?? $this->getContext($context, "rate")))) {
                echo "piwik-enriched-headline=\"";
                echo \Piwik\piwik_escape_filter($this->env, ($context["rate"] ?? $this->getContext($context, "rate")), "html_attr");
                echo "\"";
            }
            // line 7
            echo "            >";
            $this->displayBlock('helpText', $context, $blocks);
            echo \Piwik\piwik_escape_filter($this->env, ($context["title"] ?? $this->getContext($context, "title")), "html", null, true);
            echo "</h2>
        ";
        }
        // line 9
        echo "
        ";
        // line 10
        $this->displayBlock('content', $context, $blocks);
        // line 12
        echo "    </div>
</div>";
    }

    // line 7
    public function block_helpText($context, array $blocks = array())
    {
    }

    // line 10
    public function block_content($context, array $blocks = array())
    {
        // line 11
        echo "        ";
    }

    public function getTemplateName()
    {
        return "contentBlock.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  67 => 11,  64 => 10,  59 => 7,  54 => 12,  52 => 10,  49 => 9,  42 => 7,  36 => 6,  30 => 5,  27 => 4,  25 => 3,  21 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("<div class=\"card\">
    <div class=\"card-content\">
        {% if title is defined and title %}
            <h2 class=\"card-title\"
                  {% if rate is defined and rate and rate is true %}piwik-enriched-headline=\"{{ title|e('html_attr') }}\"
                  {% elseif rate is defined and rate and rate %}piwik-enriched-headline=\"{{ rate|e('html_attr') }}\"{% endif %}
            >{% block helpText %}{% endblock %}{{ title }}</h2>
        {% endif %}

        {% block content %}
        {% endblock %}
    </div>
</div>", "contentBlock.twig", "/var/www/html/plugins/Morpheus/templates/contentBlock.twig");
    }
}

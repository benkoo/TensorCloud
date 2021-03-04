<?php

/* @Login/_formErrors.twig */
class __TwigTemplate_db60673a7a8b7b4722f91a9aaf5013f312f8e0906cb2798c7e56275610355cdb extends Twig_Template
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
        echo "
";
        // line 2
        if ((array_key_exists("formErrors", $context) &&  !twig_test_empty(($context["formErrors"] ?? $this->getContext($context, "formErrors"))))) {
            // line 3
            echo "    <div piwik-notification
         noclear=\"true\"
         context=\"error\">
        ";
            // line 6
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable(($context["formErrors"] ?? $this->getContext($context, "formErrors")));
            foreach ($context['_seq'] as $context["_key"] => $context["data"]) {
                // line 7
                echo "            <strong>";
                echo \Piwik\piwik_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("General_Error")), "html", null, true);
                echo "</strong>: ";
                echo $context["data"];
                echo "
            <br/>
        ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['data'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 10
            echo "    </div>
";
        }
    }

    public function getTemplateName()
    {
        return "@Login/_formErrors.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  45 => 10,  33 => 7,  29 => 6,  24 => 3,  22 => 2,  19 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("
{% if formErrors is defined and formErrors is not empty %}
    <div piwik-notification
         noclear=\"true\"
         context=\"error\">
        {% for data in formErrors %}
            <strong>{{ 'General_Error'|translate }}</strong>: {{ data|raw }}
            <br/>
        {% endfor %}
    </div>
{% endif %}
", "@Login/_formErrors.twig", "/var/www/html/plugins/Login/templates/_formErrors.twig");
    }
}

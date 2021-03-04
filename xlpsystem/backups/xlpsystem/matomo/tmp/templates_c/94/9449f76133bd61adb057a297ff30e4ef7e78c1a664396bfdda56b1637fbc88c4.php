<?php

/* genericForm.twig */
class __TwigTemplate_e828a6dc55124501a32c3de3f095ee164c691c69123115577174549498c2a0c7 extends Twig_Template
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
        if ($this->getAttribute(($context["form_data"] ?? $this->getContext($context, "form_data")), "errors", array())) {
            // line 2
            echo "\t<div class=\"alert alert-warning\">
\t\t<strong>";
            // line 3
            echo \Piwik\piwik_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("Installation_PleaseFixTheFollowingErrors")), "html", null, true);
            echo ":</strong>
\t\t<ul>
            ";
            // line 5
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable($this->getAttribute(($context["form_data"] ?? $this->getContext($context, "form_data")), "errors", array()));
            foreach ($context['_seq'] as $context["_key"] => $context["data"]) {
                // line 6
                echo "\t\t\t\t<li>";
                echo $context["data"];
                echo "</li>
            ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['data'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 8
            echo "\t\t</ul>
\t</div>
";
        }
        // line 11
        echo "
<form ";
        // line 12
        echo $this->getAttribute(($context["form_data"] ?? $this->getContext($context, "form_data")), "attributes", array());
        echo ">
    ";
        // line 14
        echo "    ";
        echo twig_join_filter($this->getAttribute(($context["form_data"] ?? $this->getContext($context, "form_data")), "hidden", array()));
        echo "

    ";
        // line 16
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["element_list"] ?? $this->getContext($context, "element_list")));
        foreach ($context['_seq'] as $context["_key"] => $context["fieldname"]) {
            // line 17
            echo "        ";
            if ($this->getAttribute(($context["form_data"] ?? null), $context["fieldname"], array(), "array", true, true)) {
                // line 18
                echo "            <div class=\"row form-group\">
                <div class=\"col s12 m12 l6\">
                    ";
                // line 20
                if (($this->getAttribute($this->getAttribute(($context["form_data"] ?? $this->getContext($context, "form_data")), $context["fieldname"], array(), "array"), "type", array()) == "checkbox")) {
                    // line 21
                    echo "                        <label class=\"checkbox\">
                            ";
                    // line 22
                    echo $this->getAttribute($this->getAttribute(($context["form_data"] ?? $this->getContext($context, "form_data")), $context["fieldname"], array(), "array"), "html", array());
                    echo "
                        </label>
                    ";
                } elseif ($this->getAttribute($this->getAttribute(                // line 24
($context["form_data"] ?? $this->getContext($context, "form_data")), $context["fieldname"], array(), "array"), "label", array())) {
                    // line 25
                    echo "                        <label>
                            ";
                    // line 26
                    echo $this->getAttribute($this->getAttribute(($context["form_data"] ?? $this->getContext($context, "form_data")), $context["fieldname"], array(), "array"), "label", array());
                    echo "
                        </label>
                        ";
                    // line 28
                    echo $this->getAttribute($this->getAttribute(($context["form_data"] ?? $this->getContext($context, "form_data")), $context["fieldname"], array(), "array"), "html", array());
                    echo "
                    ";
                } elseif (($this->getAttribute($this->getAttribute(                // line 29
($context["form_data"] ?? $this->getContext($context, "form_data")), $context["fieldname"], array(), "array"), "type", array()) == "hidden")) {
                    // line 30
                    echo "                        ";
                    echo $this->getAttribute($this->getAttribute(($context["form_data"] ?? $this->getContext($context, "form_data")), $context["fieldname"], array(), "array"), "html", array());
                    echo "
                    ";
                }
                // line 32
                echo "                </div>
            </div>
        ";
            }
            // line 35
            echo "    ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['fieldname'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 36
        echo "
    ";
        // line 37
        if ($this->getAttribute($this->getAttribute(($context["form_data"] ?? $this->getContext($context, "form_data")), "submit", array()), "html", array())) {
            // line 38
            echo "        <div class=\"row\">
            <div class=\"col s12\">
                ";
            // line 40
            echo $this->getAttribute($this->getAttribute(($context["form_data"] ?? $this->getContext($context, "form_data")), "submit", array()), "html", array());
            echo "
            </div>
        </div>
    ";
        }
        // line 44
        echo "</form>
";
    }

    public function getTemplateName()
    {
        return "genericForm.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  130 => 44,  123 => 40,  119 => 38,  117 => 37,  114 => 36,  108 => 35,  103 => 32,  97 => 30,  95 => 29,  91 => 28,  86 => 26,  83 => 25,  81 => 24,  76 => 22,  73 => 21,  71 => 20,  67 => 18,  64 => 17,  60 => 16,  54 => 14,  50 => 12,  47 => 11,  42 => 8,  33 => 6,  29 => 5,  24 => 3,  21 => 2,  19 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("{% if form_data.errors %}
\t<div class=\"alert alert-warning\">
\t\t<strong>{{ 'Installation_PleaseFixTheFollowingErrors'|translate }}:</strong>
\t\t<ul>
            {% for data in form_data.errors %}
\t\t\t\t<li>{{ data|raw }}</li>
            {% endfor %}
\t\t</ul>
\t</div>
{% endif %}

<form {{ form_data.attributes|raw }}>
    {# display any hidden input field #}
    {{ form_data.hidden|join|raw }}

    {% for fieldname in element_list %}
        {% if form_data[fieldname] is defined %}
            <div class=\"row form-group\">
                <div class=\"col s12 m12 l6\">
                    {% if form_data[fieldname].type == 'checkbox' %}
                        <label class=\"checkbox\">
                            {{ form_data[fieldname].html|raw }}
                        </label>
                    {% elseif form_data[fieldname].label %}
                        <label>
                            {{ form_data[fieldname].label|raw }}
                        </label>
                        {{ form_data[fieldname].html|raw }}
                    {% elseif form_data[fieldname].type == 'hidden' %}
                        {{ form_data[fieldname].html|raw }}
                    {% endif %}
                </div>
            </div>
        {% endif %}
    {% endfor %}

    {% if form_data.submit.html %}
        <div class=\"row\">
            <div class=\"col s12\">
                {{ form_data.submit.html|raw }}
            </div>
        </div>
    {% endif %}
</form>
", "genericForm.twig", "/var/www/html/plugins/Morpheus/templates/genericForm.twig");
    }
}

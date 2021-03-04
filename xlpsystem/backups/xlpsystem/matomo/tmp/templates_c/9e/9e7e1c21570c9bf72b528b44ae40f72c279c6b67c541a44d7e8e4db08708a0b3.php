<?php

/* @CoreHome/_donate.twig */
class __TwigTemplate_5c88c1780d501229c152e8f6fa8a8b04067f077b313d5f98fd9d9664f9965921 extends Twig_Template
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
        echo "<div class=\"piwik-donate-call\">
    <div class=\"piwik-donate-message\">
        ";
        // line 3
        if (array_key_exists("msg", $context)) {
            // line 4
            echo "            ";
            echo \Piwik\piwik_escape_filter($this->env, ($context["msg"] ?? $this->getContext($context, "msg")), "html", null, true);
            echo "
        ";
        } else {
            // line 6
            echo "            <p>";
            echo \Piwik\piwik_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("CoreHome_DonateCall1")), "html", null, true);
            echo "</p>
            <p><strong>";
            // line 7
            echo \Piwik\piwik_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("CoreHome_DonateCall2")), "html", null, true);
            echo "</strong></p>
            <p>";
            // line 8
            echo call_user_func_array($this->env->getFilter('translate')->getCallable(), array("CoreHome_DonateCall3", "<strong>", "</strong>", "<a target=\"_blank\" rel=\"nofollow\" href=\"https://matomo.org/recommends/premium-plugins/\"><strong>", "</strong></a>"));
            echo "</p>
        ";
        }
        // line 10
        echo "    </div>

    <span id=\"piwik-worth\">";
        // line 12
        echo \Piwik\piwik_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("CoreHome_HowMuchIsPiwikWorth")), "html", null, true);
        echo "</span>

    <div class=\"donate-form-instructions\">(";
        // line 14
        echo \Piwik\piwik_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("CoreHome_DonateFormInstructions")), "html", null, true);
        echo ")</div>

    <form action=\"index.php?module=CoreHome&action=redirectToPaypal&idSite=1\" method=\"post\" target=\"_blank\">
        <input type=\"hidden\" name=\"cmd\" value=\"_s-xclick\"/>
        <input type=\"hidden\" name=\"hosted_button_id\" value=\"DVKLY73RS7JTE\"/>
        <input type=\"hidden\" name=\"currency_code\" value=\"USD\"/>
        <input type=\"hidden\" name=\"on0\" value=\"Matomo Supporter\"/>

        <div class=\"piwik-donate-slider\">
            <div class=\"slider-range\">
                <div class=\"slider-position\"></div>
            </div>
            <div style=\"display:inline-block;\">
                <div class=\"slider-donate-amount\">\$30/";
        // line 27
        echo \Piwik\piwik_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("Intl_Year_Short")), "html", null, true);
        echo "</div>

                <img class=\"slider-smiley-face\" width=\"40\" height=\"40\" src=\"plugins/Morpheus/images/smileyprog_1.png\"/>
            </div>

            <input type=\"hidden\" name=\"os0\" value=\"Option 1\"/>
        </div>

        <div class=\"donate-submit\">
            <input type=\"image\" src=\"plugins/Morpheus/images/paypal_subscribe.png\" border=\"0\" name=\"submit\"
                title=\"";
        // line 37
        echo \Piwik\piwik_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("CoreHome_SubscribeAndBecomePiwikSupporter")), "html", null, true);
        echo "\"/>
\t\t\t<a class=\"donate-spacer\">";
        // line 38
        echo \Piwik\piwik_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("CoreHome_MakeOneTimeDonation")), "html", null, true);
        echo "</a>
            <a href=\"index.php?module=CoreHome&action=redirectToPaypal&idSite=1&cmd=_s-xclick&hosted_button_id=RPL23NJURMTFA&bb2_screener_=1357583494+83.233.186.82\"
               rel=\"noreferrer\"  target=\"_blank\" class=\"donate-one-time\">";
        // line 40
        echo \Piwik\piwik_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("CoreHome_MakeOneTimeDonation")), "html", null, true);
        echo "</a>
        </div>

        <!-- to cache images -->
        <img style=\"display:none;\" src=\"plugins/Morpheus/images/smileyprog_0.png\"/>
        <img style=\"display:none;\" src=\"plugins/Morpheus/images/smileyprog_1.png\"/>
        <img style=\"display:none;\" src=\"plugins/Morpheus/images/smileyprog_2.png\"/>
        <img style=\"display:none;\" src=\"plugins/Morpheus/images/smileyprog_3.png\"/>
        <img style=\"display:none;\" src=\"plugins/Morpheus/images/smileyprog_4.png\"/>
    </form>
    ";
        // line 50
        if (array_key_exists("footerMessage", $context)) {
            // line 51
            echo "        <div class=\"form-description\">
            ";
            // line 52
            echo \Piwik\piwik_escape_filter($this->env, ($context["footerMessage"] ?? $this->getContext($context, "footerMessage")), "html", null, true);
            echo "
        </div>
    ";
        }
        // line 55
        echo "</div>
<script type=\"text/javascript\">
\$(document).ready(function () {
    // Note: this will cause problems if more than one donate form is on the page
    \$('.piwik-donate-slider').each(function () {
        \$(this).trigger('piwik:changePosition', {position: 1});
    });
});
</script>
";
    }

    public function getTemplateName()
    {
        return "@CoreHome/_donate.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  116 => 55,  110 => 52,  107 => 51,  105 => 50,  92 => 40,  87 => 38,  83 => 37,  70 => 27,  54 => 14,  49 => 12,  45 => 10,  40 => 8,  36 => 7,  31 => 6,  25 => 4,  23 => 3,  19 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("<div class=\"piwik-donate-call\">
    <div class=\"piwik-donate-message\">
        {% if msg is defined %}
            {{ msg }}
        {% else %}
            <p>{{ 'CoreHome_DonateCall1'|translate }}</p>
            <p><strong>{{ 'CoreHome_DonateCall2'|translate }}</strong></p>
            <p>{{ 'CoreHome_DonateCall3'|translate('<strong>','</strong>', '<a target=\"_blank\" rel=\"nofollow\" href=\"https://matomo.org/recommends/premium-plugins/\"><strong>', '</strong></a>')|raw }}</p>
        {% endif %}
    </div>

    <span id=\"piwik-worth\">{{ 'CoreHome_HowMuchIsPiwikWorth'|translate }}</span>

    <div class=\"donate-form-instructions\">({{ 'CoreHome_DonateFormInstructions'|translate }})</div>

    <form action=\"index.php?module=CoreHome&action=redirectToPaypal&idSite=1\" method=\"post\" target=\"_blank\">
        <input type=\"hidden\" name=\"cmd\" value=\"_s-xclick\"/>
        <input type=\"hidden\" name=\"hosted_button_id\" value=\"DVKLY73RS7JTE\"/>
        <input type=\"hidden\" name=\"currency_code\" value=\"USD\"/>
        <input type=\"hidden\" name=\"on0\" value=\"Matomo Supporter\"/>

        <div class=\"piwik-donate-slider\">
            <div class=\"slider-range\">
                <div class=\"slider-position\"></div>
            </div>
            <div style=\"display:inline-block;\">
                <div class=\"slider-donate-amount\">\$30/{{ 'Intl_Year_Short'|translate }}</div>

                <img class=\"slider-smiley-face\" width=\"40\" height=\"40\" src=\"plugins/Morpheus/images/smileyprog_1.png\"/>
            </div>

            <input type=\"hidden\" name=\"os0\" value=\"Option 1\"/>
        </div>

        <div class=\"donate-submit\">
            <input type=\"image\" src=\"plugins/Morpheus/images/paypal_subscribe.png\" border=\"0\" name=\"submit\"
                title=\"{{ 'CoreHome_SubscribeAndBecomePiwikSupporter'|translate }}\"/>
\t\t\t<a class=\"donate-spacer\">{{ 'CoreHome_MakeOneTimeDonation'|translate }}</a>
            <a href=\"index.php?module=CoreHome&action=redirectToPaypal&idSite=1&cmd=_s-xclick&hosted_button_id=RPL23NJURMTFA&bb2_screener_=1357583494+83.233.186.82\"
               rel=\"noreferrer\"  target=\"_blank\" class=\"donate-one-time\">{{ 'CoreHome_MakeOneTimeDonation'|translate }}</a>
        </div>

        <!-- to cache images -->
        <img style=\"display:none;\" src=\"plugins/Morpheus/images/smileyprog_0.png\"/>
        <img style=\"display:none;\" src=\"plugins/Morpheus/images/smileyprog_1.png\"/>
        <img style=\"display:none;\" src=\"plugins/Morpheus/images/smileyprog_2.png\"/>
        <img style=\"display:none;\" src=\"plugins/Morpheus/images/smileyprog_3.png\"/>
        <img style=\"display:none;\" src=\"plugins/Morpheus/images/smileyprog_4.png\"/>
    </form>
    {% if footerMessage is defined %}
        <div class=\"form-description\">
            {{ footerMessage }}
        </div>
    {% endif %}
</div>
<script type=\"text/javascript\">
\$(document).ready(function () {
    // Note: this will cause problems if more than one donate form is on the page
    \$('.piwik-donate-slider').each(function () {
        \$(this).trigger('piwik:changePosition', {position: 1});
    });
});
</script>
", "@CoreHome/_donate.twig", "/var/www/html/plugins/CoreHome/templates/_donate.twig");
    }
}

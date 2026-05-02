<?php

use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Extension\CoreExtension;
use Twig\Extension\SandboxExtension;
use Twig\Markup;
use Twig\Sandbox\SecurityError;
use Twig\Sandbox\SecurityNotAllowedTagError;
use Twig\Sandbox\SecurityNotAllowedFilterError;
use Twig\Sandbox\SecurityNotAllowedFunctionError;
use Twig\Source;
use Twig\Template;
use Twig\TemplateWrapper;

/* @ilovemyfujitsu/includes/footer.html.twig */
class __TwigTemplate_0a115483052d8ee63ef6bf3f814b48ed extends Template
{
    private Source $source;
    /**
     * @var array<string, Template>
     */
    private array $macros = [];

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->parent = false;

        $this->blocks = [
        ];
        $this->sandbox = $this->extensions[SandboxExtension::class];
        $this->checkSecurity();
    }

    protected function doDisplay(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        // line 1
        yield "<footer class=\"fujitsu-footer\">
  <div class=\"container\">
    <div class=\"row g-4\">
      <div class=\"col-lg-5\">
        <img class=\"fujitsu-footer__logo\" src=\"";
        // line 5
        yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, ($context["theme_path"] ?? null), "html", null, true);
        yield "/assets/images/fujitsu-logo.png\" alt=\"I Love My Fujitsu\">
        <p>Helping Hawaii homeowners and businesses ask for the air conditioning system built for island comfort: Fujitsu.</p>
        <div class=\"fujitsu-social fujitsu-social--footer\" aria-label=\"Social links\">
          <a href=\"https://www.instagram.com/ilovemyfujitsu/\" target=\"_blank\" rel=\"noopener noreferrer\" aria-label=\"I Love My Fujitsu on Instagram\">
            <svg viewBox=\"0 0 24 24\" aria-hidden=\"true\" focusable=\"false\"><rect x=\"3.5\" y=\"3.5\" width=\"17\" height=\"17\" rx=\"5\"></rect><circle cx=\"12\" cy=\"12\" r=\"4\"></circle><circle cx=\"17.4\" cy=\"6.6\" r=\"1\"></circle></svg>
          </a>
          <a href=\"https://www.facebook.com/ilovemyfujitsuhawaii\" target=\"_blank\" rel=\"noopener noreferrer\" aria-label=\"I Love My Fujitsu on Facebook\">
            <svg viewBox=\"0 0 24 24\" aria-hidden=\"true\" focusable=\"false\"><path d=\"M14 8.8V7.2c0-.7.4-1.1 1.2-1.1h1.9V3h-2.8C11.5 3 10 4.6 10 7.1v1.7H7.8V12H10v9h4v-9h2.8l.5-3.2H14z\"></path></svg>
          </a>
        </div>
      </div>
      <div class=\"col-lg-3\">
        <h2>Navigate</h2>
        ";
        // line 18
        yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, ($context["page"] ?? null), "footer", [], "any", false, false, true, 18), "html", null, true);
        yield "
      </div>
      <div class=\"col-lg-4\">
        <h2>Local Support</h2>
        <p>Backed in Hawaii by Admor HVAC Products with local inventory, parts, training, and contractor support.</p>
        <p><strong>(808) 570-0300</strong><br>2928 Kaihikapu Street<br>Honolulu, HI 96819</p>
      </div>
    </div>
    <div class=\"fujitsu-footer__bottom\">
      <span>&copy; ";
        // line 27
        yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->extensions['Twig\Extension\CoreExtension']->formatDate("now", "Y"), "html", null, true);
        yield " I Love My Fujitsu.</span>
      <span>Ask your contractor for Fujitsu by name.</span>
    </div>
  </div>
</footer>
";
        $this->env->getExtension('\Drupal\Core\Template\TwigExtension')
            ->checkDeprecations($context, ["theme_path", "page"]);        yield from [];
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName(): string
    {
        return "@ilovemyfujitsu/includes/footer.html.twig";
    }

    /**
     * @codeCoverageIgnore
     */
    public function isTraitable(): bool
    {
        return false;
    }

    /**
     * @codeCoverageIgnore
     */
    public function getDebugInfo(): array
    {
        return array (  78 => 27,  66 => 18,  50 => 5,  44 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("", "@ilovemyfujitsu/includes/footer.html.twig", "/private/tmp/ilovemyfujitsu-drupal/web/themes/custom/ilovemyfujitsu/templates/includes/footer.html.twig");
    }
    
    public function checkSecurity()
    {
        static $tags = [];
        static $filters = ["escape" => 5, "date" => 27];
        static $functions = [];

        try {
            $this->sandbox->checkSecurity(
                [],
                ['escape', 'date'],
                [],
                $this->source
            );
        } catch (SecurityError $e) {
            $e->setSourceContext($this->source);

            if ($e instanceof SecurityNotAllowedTagError && isset($tags[$e->getTagName()])) {
                $e->setTemplateLine($tags[$e->getTagName()]);
            } elseif ($e instanceof SecurityNotAllowedFilterError && isset($filters[$e->getFilterName()])) {
                $e->setTemplateLine($filters[$e->getFilterName()]);
            } elseif ($e instanceof SecurityNotAllowedFunctionError && isset($functions[$e->getFunctionName()])) {
                $e->setTemplateLine($functions[$e->getFunctionName()]);
            }

            throw $e;
        }

    }
}

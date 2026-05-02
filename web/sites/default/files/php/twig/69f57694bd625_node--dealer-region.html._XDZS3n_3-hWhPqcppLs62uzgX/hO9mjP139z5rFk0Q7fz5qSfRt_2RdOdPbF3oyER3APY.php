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

/* themes/custom/ilovemyfujitsu/templates/content/node--dealer-region.html.twig */
class __TwigTemplate_383fc88d7bd143e309379d10e0e83e7b extends Template
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
        yield "<article";
        yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, ($context["attributes"] ?? null), "addClass", ["ilf-structured-node", "ilf-structured-node--dealer-region"], "method", false, false, true, 1), "html", null, true);
        yield ">
  <header class=\"fujitsu-page-hero\">
    <div class=\"container\">
      <p class=\"fujitsu-eyebrow\">Find a Fujitsu dealer</p>
      <h1>";
        // line 5
        yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, ($context["label"] ?? null), "html", null, true);
        yield "</h1>
      <p>Choose Fujitsu before the estimate is written. Use this island locator pathway to connect with contractor support near you.</p>
    </div>
  </header>

  <div class=\"fujitsu-page-body\">
    <div class=\"container\">
      <div class=\"ilf-dealer-region-layout\">
        <section class=\"ilf-dealer-region-main\">
          <p class=\"ilf-kicker\">";
        // line 14
        yield (((($tmp = CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["node"] ?? null), "field_island_region", [], "any", false, false, true, 14), "entity", [], "any", false, false, true, 14)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) ? ($this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["node"] ?? null), "field_island_region", [], "any", false, false, true, 14), "entity", [], "any", false, false, true, 14), "label", [], "any", false, false, true, 14), "html", null, true)) : ("Hawaii"));
        yield " contractor pathway</p>
          <div class=\"ilf-dealer-region-copy\">
            ";
        // line 16
        yield $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar(CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["node"] ?? null), "body", [], "any", false, false, true, 16), "value", [], "any", false, false, true, 16));
        yield "
          </div>

          <div class=\"ilf-dealer-steps\" aria-label=\"How to use this page\">
            <article>
              <strong>1</strong>
              <h2>Request Fujitsu by name</h2>
              <p>Tell your contractor you want Fujitsu included in the quote so efficiency, warranty, and local support are part of the decision.</p>
            </article>
            <article>
              <strong>2</strong>
              <h2>Confirm the right system</h2>
              <p>Review brochures and match the system to your home, business, room count, humidity needs, and daily usage.</p>
            </article>
            <article>
              <strong>3</strong>
              <h2>Install with confidence</h2>
              <p>Fujitsu contractors can connect with Hawaii-based product support, parts access, and warranty guidance through Admor.</p>
            </article>
          </div>

          <section class=\"ilf-callout ilf-callout--compact\">
            <h2>Why choose a Fujitsu contractor?</h2>
            <p>Fujitsu-trained contractors understand system matching, installation quality, warranty requirements, and local support channels. That means a smoother path from estimate to long-term comfort.</p>
          </section>
        </section>

        <aside class=\"ilf-dealer-locator-card\" aria-label=\"Contractor locator actions\">
          <p class=\"fujitsu-eyebrow\">Official locator</p>
          <h2>";
        // line 45
        yield (((($tmp = CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["node"] ?? null), "field_island_region", [], "any", false, false, true, 45), "entity", [], "any", false, false, true, 45)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) ? ($this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["node"] ?? null), "field_island_region", [], "any", false, false, true, 45), "entity", [], "any", false, false, true, 45), "label", [], "any", false, false, true, 45), "html", null, true)) : ($this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, ($context["label"] ?? null), "html", null, true)));
        yield " Fujitsu support</h2>
          <p>Open the contractor locator, then ask each installer to quote Fujitsu as the preferred AC system.</p>
          <div class=\"ilf-dealer-meta\">
            ";
        // line 48
        if ((($tmp = CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["node"] ?? null), "field_island_region", [], "any", false, false, true, 48), "entity", [], "any", false, false, true, 48)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
            // line 49
            yield "              <p><strong>Island</strong><span>";
            yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["node"] ?? null), "field_island_region", [], "any", false, false, true, 49), "entity", [], "any", false, false, true, 49), "label", [], "any", false, false, true, 49), "html", null, true);
            yield "</span></p>
            ";
        }
        // line 51
        yield "            <p><strong>Best next step</strong><span>Find a contractor, compare Fujitsu products, then request Fujitsu by name.</span></p>
          </div>
          <div class=\"ilf-dealer-locator-card__actions\">
            ";
        // line 54
        if ((($tmp = CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["node"] ?? null), "field_dealer_locator_url", [], "any", false, false, true, 54), "uri", [], "any", false, false, true, 54)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
            // line 55
            yield "              <a class=\"btn-main\" href=\"";
            yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["node"] ?? null), "field_dealer_locator_url", [], "any", false, false, true, 55), "uri", [], "any", false, false, true, 55), "html", null, true);
            yield "\" data-ilf-contractor-link>";
            yield ((CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["node"] ?? null), "field_cta_text", [], "any", false, false, true, 55), "value", [], "any", false, false, true, 55)) ? ($this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["node"] ?? null), "field_cta_text", [], "any", false, false, true, 55), "value", [], "any", false, false, true, 55), "html", null, true)) : ("Open contractor locator"));
            yield "</a>
            ";
        }
        // line 57
        yield "            <a class=\"btn-main btn-outline\" href=\"/products\">Explore Fujitsu Products</a>
            <a class=\"btn-main btn-outline\" href=\"/fujitsu-vs-mitsubishi\">Compare Fujitsu brands</a>
            <a class=\"ilf-teaser-card__link\" href=\"/find-a-fujitsu-contractor\">View all islands</a>
          </div>
        </aside>
      </div>

      ";
        // line 64
        if ((($tmp = ($context["ilf_testimonials"] ?? null)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
            // line 65
            yield "        <section class=\"ilf-testimonials ilf-testimonials--embedded\">
          <div class=\"fujitsu-section-heading\">
            <p class=\"fujitsu-eyebrow\">Local proof</p>
            <h2>Fujitsu comfort stories from Hawaii customers.</h2>
          </div>
          <div class=\"ilf-testimonials__grid\">
            ";
            // line 71
            $context['_parent'] = $context;
            $context['_seq'] = CoreExtension::ensureTraversable(($context["ilf_testimonials"] ?? null));
            foreach ($context['_seq'] as $context["_key"] => $context["item"]) {
                // line 72
                yield "              <article>
                <p>“";
                // line 73
                yield ((CoreExtension::getAttribute($this->env, $this->source, $context["item"], "quote", [], "any", false, false, true, 73)) ? ($this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, $context["item"], "quote", [], "any", false, false, true, 73), "html", null, true)) : ($this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, $context["item"], "summary", [], "any", false, false, true, 73), "html", null, true)));
                yield "”</p>
                <strong>";
                // line 74
                yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, $context["item"], "title", [], "any", false, false, true, 74), "html", null, true);
                yield "</strong>
                ";
                // line 75
                if ((CoreExtension::getAttribute($this->env, $this->source, $context["item"], "island", [], "any", false, false, true, 75) || CoreExtension::getAttribute($this->env, $this->source, $context["item"], "system", [], "any", false, false, true, 75))) {
                    yield "<span>";
                    yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, $context["item"], "island", [], "any", false, false, true, 75), "html", null, true);
                    if ((CoreExtension::getAttribute($this->env, $this->source, $context["item"], "island", [], "any", false, false, true, 75) && CoreExtension::getAttribute($this->env, $this->source, $context["item"], "system", [], "any", false, false, true, 75))) {
                        yield " / ";
                    }
                    yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, $context["item"], "system", [], "any", false, false, true, 75), "html", null, true);
                    yield "</span>";
                }
                // line 76
                yield "              </article>
            ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_key'], $context['item'], $context['_parent']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 78
            yield "          </div>
        </section>
      ";
        }
        // line 81
        yield "
      <nav class=\"ilf-island-jump ilf-island-jump--centered\" aria-label=\"Dealer island navigation\">
        <a href=\"/find-a-dealer/oahu-dealers\">Oahu</a>
        <a href=\"/find-a-dealer/maui-dealers\">Maui</a>
        <a href=\"/find-a-dealer/kauai-dealers\">Kauai</a>
        <a href=\"/find-a-dealer/big-island-dealers\">Big Island</a>
      </nav>
    </div>
  </div>
</article>
";
        $this->env->getExtension('\Drupal\Core\Template\TwigExtension')
            ->checkDeprecations($context, ["attributes", "label", "node", "ilf_testimonials"]);        yield from [];
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName(): string
    {
        return "themes/custom/ilovemyfujitsu/templates/content/node--dealer-region.html.twig";
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
        return array (  186 => 81,  181 => 78,  174 => 76,  164 => 75,  160 => 74,  156 => 73,  153 => 72,  149 => 71,  141 => 65,  139 => 64,  130 => 57,  122 => 55,  120 => 54,  115 => 51,  109 => 49,  107 => 48,  101 => 45,  69 => 16,  64 => 14,  52 => 5,  44 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("", "themes/custom/ilovemyfujitsu/templates/content/node--dealer-region.html.twig", "/private/tmp/ilovemyfujitsu-drupal/web/themes/custom/ilovemyfujitsu/templates/content/node--dealer-region.html.twig");
    }
    
    public function checkSecurity()
    {
        static $tags = ["if" => 48, "for" => 71];
        static $filters = ["escape" => 1, "raw" => 16];
        static $functions = [];

        try {
            $this->sandbox->checkSecurity(
                ['if', 'for'],
                ['escape', 'raw'],
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

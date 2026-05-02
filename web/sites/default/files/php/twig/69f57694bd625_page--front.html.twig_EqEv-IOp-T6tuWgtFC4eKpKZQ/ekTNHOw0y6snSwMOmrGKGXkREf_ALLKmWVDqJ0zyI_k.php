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

/* themes/custom/ilovemyfujitsu/templates/layout/page--front.html.twig */
class __TwigTemplate_06f02947e87945c403a9ea6de8c338b6 extends Template
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
        yield "<div id=\"wrapper\" class=\"fujitsu-shell\">
  <script type=\"application/ld+json\">
    {
      \"@context\": \"https://schema.org\",
      \"@graph\": [
        {
          \"@type\": \"Organization\",
          \"@id\": \"https://ilovemyfujitsu.com/#organization\",
          \"name\": \"I Love My Fujitsu\",
          \"url\": \"https://ilovemyfujitsu.com\",
          \"logo\": \"https://ilovemyfujitsu.com/themes/custom/ilovemyfujitsu/assets/images/fujitsu-logo.png\",
          \"sameAs\": [
            \"https://www.instagram.com/ilovemyfujitsu/\",
            \"https://www.facebook.com/ilovemyfujitsuhawaii\"
          ],
          \"brand\": {
            \"@type\": \"Brand\",
            \"name\": \"Fujitsu\"
          }
        },
        {
          \"@type\": \"LocalBusiness\",
          \"@id\": \"https://ilovemyfujitsu.com/#localbusiness\",
          \"name\": \"I Love My Fujitsu Hawaii\",
          \"url\": \"https://ilovemyfujitsu.com\",
          \"telephone\": \"+1-808-841-7400\",
          \"address\": {
            \"@type\": \"PostalAddress\",
            \"addressRegion\": \"HI\",
            \"addressCountry\": \"US\"
          },
          \"parentOrganization\": {
            \"@id\": \"https://ilovemyfujitsu.com/#organization\"
          }
        },
        {
          \"@type\": \"WebSite\",
          \"@id\": \"https://ilovemyfujitsu.com/#website\",
          \"url\": \"https://ilovemyfujitsu.com\",
          \"name\": \"I Love My Fujitsu\",
          \"publisher\": {
            \"@id\": \"https://ilovemyfujitsu.com/#organization\"
          },
          \"potentialAction\": {
            \"@type\": \"SearchAction\",
            \"target\": \"https://ilovemyfujitsu.com/search/node?keys={search_term_string}\",
            \"query-input\": \"required name=search_term_string\"
          }
        }
      ]
    }
  </script>
  ";
        // line 53
        yield from $this->load("@ilovemyfujitsu/includes/header.html.twig", 53)->unwrap()->yield($context);
        // line 54
        yield "
  <main id=\"main-content\" class=\"fujitsu-main\">
    ";
        // line 56
        $context["main_cta"] = (((CoreExtension::getAttribute($this->env, $this->source, ($context["homepage_ctas"] ?? null), "Homepage main CTA", [], "array", true, true, true, 56) &&  !(null === (($_v0 = ($context["homepage_ctas"] ?? null)) && is_array($_v0) || $_v0 instanceof ArrayAccess && in_array($_v0::class, CoreExtension::ARRAY_LIKE_CLASSES, true) ? ($_v0["Homepage main CTA"] ?? null) : CoreExtension::getAttribute($this->env, $this->source, ($context["homepage_ctas"] ?? null), "Homepage main CTA", [], "array", false, false, true, 56))))) ? ((($_v1 = ($context["homepage_ctas"] ?? null)) && is_array($_v1) || $_v1 instanceof ArrayAccess && in_array($_v1::class, CoreExtension::ARRAY_LIKE_CLASSES, true) ? ($_v1["Homepage main CTA"] ?? null) : CoreExtension::getAttribute($this->env, $this->source, ($context["homepage_ctas"] ?? null), "Homepage main CTA", [], "array", false, false, true, 56))) : (null));
        // line 57
        yield "    ";
        $context["dealer_cta"] = (((CoreExtension::getAttribute($this->env, $this->source, ($context["homepage_ctas"] ?? null), "Find a Fujitsu Dealer CTA", [], "array", true, true, true, 57) &&  !(null === (($_v2 = ($context["homepage_ctas"] ?? null)) && is_array($_v2) || $_v2 instanceof ArrayAccess && in_array($_v2::class, CoreExtension::ARRAY_LIKE_CLASSES, true) ? ($_v2["Find a Fujitsu Dealer CTA"] ?? null) : CoreExtension::getAttribute($this->env, $this->source, ($context["homepage_ctas"] ?? null), "Find a Fujitsu Dealer CTA", [], "array", false, false, true, 57))))) ? ((($_v3 = ($context["homepage_ctas"] ?? null)) && is_array($_v3) || $_v3 instanceof ArrayAccess && in_array($_v3::class, CoreExtension::ARRAY_LIKE_CLASSES, true) ? ($_v3["Find a Fujitsu Dealer CTA"] ?? null) : CoreExtension::getAttribute($this->env, $this->source, ($context["homepage_ctas"] ?? null), "Find a Fujitsu Dealer CTA", [], "array", false, false, true, 57))) : (null));
        // line 58
        yield "    ";
        $context["help_cta"] = (((CoreExtension::getAttribute($this->env, $this->source, ($context["homepage_ctas"] ?? null), "Need Help Choosing a System CTA", [], "array", true, true, true, 58) &&  !(null === (($_v4 = ($context["homepage_ctas"] ?? null)) && is_array($_v4) || $_v4 instanceof ArrayAccess && in_array($_v4::class, CoreExtension::ARRAY_LIKE_CLASSES, true) ? ($_v4["Need Help Choosing a System CTA"] ?? null) : CoreExtension::getAttribute($this->env, $this->source, ($context["homepage_ctas"] ?? null), "Need Help Choosing a System CTA", [], "array", false, false, true, 58))))) ? ((($_v5 = ($context["homepage_ctas"] ?? null)) && is_array($_v5) || $_v5 instanceof ArrayAccess && in_array($_v5::class, CoreExtension::ARRAY_LIKE_CLASSES, true) ? ($_v5["Need Help Choosing a System CTA"] ?? null) : CoreExtension::getAttribute($this->env, $this->source, ($context["homepage_ctas"] ?? null), "Need Help Choosing a System CTA", [], "array", false, false, true, 58))) : (null));
        // line 59
        yield "    ";
        $context["call_cta"] = (((CoreExtension::getAttribute($this->env, $this->source, ($context["homepage_ctas"] ?? null), "Call Admor HVAC CTA", [], "array", true, true, true, 59) &&  !(null === (($_v6 = ($context["homepage_ctas"] ?? null)) && is_array($_v6) || $_v6 instanceof ArrayAccess && in_array($_v6::class, CoreExtension::ARRAY_LIKE_CLASSES, true) ? ($_v6["Call Admor HVAC CTA"] ?? null) : CoreExtension::getAttribute($this->env, $this->source, ($context["homepage_ctas"] ?? null), "Call Admor HVAC CTA", [], "array", false, false, true, 59))))) ? ((($_v7 = ($context["homepage_ctas"] ?? null)) && is_array($_v7) || $_v7 instanceof ArrayAccess && in_array($_v7::class, CoreExtension::ARRAY_LIKE_CLASSES, true) ? ($_v7["Call Admor HVAC CTA"] ?? null) : CoreExtension::getAttribute($this->env, $this->source, ($context["homepage_ctas"] ?? null), "Call Admor HVAC CTA", [], "array", false, false, true, 59))) : (null));
        // line 60
        yield "    ";
        $context["award_cta"] = (((CoreExtension::getAttribute($this->env, $this->source, ($context["homepage_ctas"] ?? null), "Best of Hawaii Award Trust Badge", [], "array", true, true, true, 60) &&  !(null === (($_v8 = ($context["homepage_ctas"] ?? null)) && is_array($_v8) || $_v8 instanceof ArrayAccess && in_array($_v8::class, CoreExtension::ARRAY_LIKE_CLASSES, true) ? ($_v8["Best of Hawaii Award Trust Badge"] ?? null) : CoreExtension::getAttribute($this->env, $this->source, ($context["homepage_ctas"] ?? null), "Best of Hawaii Award Trust Badge", [], "array", false, false, true, 60))))) ? ((($_v9 = ($context["homepage_ctas"] ?? null)) && is_array($_v9) || $_v9 instanceof ArrayAccess && in_array($_v9::class, CoreExtension::ARRAY_LIKE_CLASSES, true) ? ($_v9["Best of Hawaii Award Trust Badge"] ?? null) : CoreExtension::getAttribute($this->env, $this->source, ($context["homepage_ctas"] ?? null), "Best of Hawaii Award Trust Badge", [], "array", false, false, true, 60))) : (null));
        // line 61
        yield "    ";
        $context["instagram_cta"] = (((CoreExtension::getAttribute($this->env, $this->source, ($context["homepage_ctas"] ?? null), "Instagram Follow CTA", [], "array", true, true, true, 61) &&  !(null === (($_v10 = ($context["homepage_ctas"] ?? null)) && is_array($_v10) || $_v10 instanceof ArrayAccess && in_array($_v10::class, CoreExtension::ARRAY_LIKE_CLASSES, true) ? ($_v10["Instagram Follow CTA"] ?? null) : CoreExtension::getAttribute($this->env, $this->source, ($context["homepage_ctas"] ?? null), "Instagram Follow CTA", [], "array", false, false, true, 61))))) ? ((($_v11 = ($context["homepage_ctas"] ?? null)) && is_array($_v11) || $_v11 instanceof ArrayAccess && in_array($_v11::class, CoreExtension::ARRAY_LIKE_CLASSES, true) ? ($_v11["Instagram Follow CTA"] ?? null) : CoreExtension::getAttribute($this->env, $this->source, ($context["homepage_ctas"] ?? null), "Instagram Follow CTA", [], "array", false, false, true, 61))) : (null));
        // line 62
        yield "    ";
        $context["warranty_cta"] = (((CoreExtension::getAttribute($this->env, $this->source, ($context["homepage_ctas"] ?? null), "Fujitsu Warranty / Rebate Promo Block", [], "array", true, true, true, 62) &&  !(null === (($_v12 = ($context["homepage_ctas"] ?? null)) && is_array($_v12) || $_v12 instanceof ArrayAccess && in_array($_v12::class, CoreExtension::ARRAY_LIKE_CLASSES, true) ? ($_v12["Fujitsu Warranty / Rebate Promo Block"] ?? null) : CoreExtension::getAttribute($this->env, $this->source, ($context["homepage_ctas"] ?? null), "Fujitsu Warranty / Rebate Promo Block", [], "array", false, false, true, 62))))) ? ((($_v13 = ($context["homepage_ctas"] ?? null)) && is_array($_v13) || $_v13 instanceof ArrayAccess && in_array($_v13::class, CoreExtension::ARRAY_LIKE_CLASSES, true) ? ($_v13["Fujitsu Warranty / Rebate Promo Block"] ?? null) : CoreExtension::getAttribute($this->env, $this->source, ($context["homepage_ctas"] ?? null), "Fujitsu Warranty / Rebate Promo Block", [], "array", false, false, true, 62))) : (null));
        // line 63
        yield "
    <section class=\"fujitsu-hero fujitsu-hero--managed\">
      <div class=\"container\">
        <div class=\"row align-items-center g-5\">
          <div class=\"col-lg-6\">
            <p class=\"fujitsu-eyebrow\">Built for Hawaii comfort</p>
            <h1>Fujitsu Air Conditioning Systems for Hawaii Homes &amp; Businesses</h1>
            ";
        // line 70
        if ((($tmp = ($context["main_cta"] ?? null)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
            // line 71
            yield "              <div class=\"fujitsu-hero__lead\">";
            yield $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar(CoreExtension::getAttribute($this->env, $this->source, ($context["main_cta"] ?? null), "body", [], "any", false, false, true, 71));
            yield "</div>
            ";
        } else {
            // line 73
            yield "              <p class=\"fujitsu-hero__lead\">Ask your contractor for Fujitsu by name, then use the resources on this site to compare options with confidence.</p>
            ";
        }
        // line 75
        yield "            <div class=\"fujitsu-actions\">
              <a class=\"btn-main\" href=\"";
        // line 76
        yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, ((CoreExtension::getAttribute($this->env, $this->source, ($context["main_cta"] ?? null), "link", [], "any", true, true, true, 76)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, ($context["main_cta"] ?? null), "link", [], "any", false, false, true, 76), "/find-a-fujitsu-contractor")) : ("/find-a-fujitsu-contractor")), "html", null, true);
        yield "\">";
        yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, ((CoreExtension::getAttribute($this->env, $this->source, ($context["main_cta"] ?? null), "link_text", [], "any", true, true, true, 76)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, ($context["main_cta"] ?? null), "link_text", [], "any", false, false, true, 76), "Find a Fujitsu Dealer")) : ("Find a Fujitsu Dealer")), "html", null, true);
        yield "</a>
              <a class=\"btn-main btn-outline\" href=\"/products\">Explore Fujitsu Products</a>
            </div>
            <div class=\"fujitsu-trust-row\">
              <span>12-year warranty options</span>
              <span>Local parts support</span>
              <span>Certified contractors</span>
            </div>
          </div>
          <div class=\"col-lg-6\">
            ";
        // line 86
        $context["first_slide"] = Twig\Extension\CoreExtension::first($this->env->getCharset(), ($context["homepage_slides"] ?? null));
        // line 87
        yield "            <div class=\"fujitsu-hero__image\">
              ";
        // line 88
        if ((($tmp = CoreExtension::getAttribute($this->env, $this->source, ($context["first_slide"] ?? null), "image", [], "any", false, false, true, 88)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
            // line 89
            yield "                <img src=\"";
            yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, ($context["first_slide"] ?? null), "image", [], "any", false, false, true, 89), "html", null, true);
            yield "\" alt=\"";
            yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, ($context["first_slide"] ?? null), "title", [], "any", false, false, true, 89), "html", null, true);
            yield "\">
              ";
        } else {
            // line 91
            yield "                <img src=\"";
            yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, ($context["theme_path"] ?? null), "html", null, true);
            yield "/vendor/coolair/images/misc/14.webp\" alt=\"Modern home comfort with Fujitsu air conditioning\">
              ";
        }
        // line 93
        yield "              <div class=\"fujitsu-hero__badge\">
                <strong>Ask by name</strong>
                <span>Make Fujitsu the system your contractor quotes first.</span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section class=\"fujitsu-why\">
      <div class=\"container\">
        <div class=\"fujitsu-why__intro\">
          <p class=\"fujitsu-eyebrow\">Why Fujitsu?</p>
          <h2>If you are installing AC in Hawaii, ask why the system is built for island comfort.</h2>
          <p>Before accepting a quote for Mitsubishi, Daikin, LG, Gree, Panasonic, or another ductless mini-split brand, compare the factors that matter most in Hawaii: humidity, salt air, quiet comfort, energy use, warranty strength, parts access, and contractor support.</p>
        </div>
        <div class=\"fujitsu-why__grid\">
          <article>
            <span>01</span>
            <h3>Built for Hawaii’s climate</h3>
            <p>Fujitsu systems are positioned for humid, salt-air environments where AC runs hard and reliability matters every day.</p>
          </article>
          <article>
            <span>02</span>
            <h3>Efficient ductless comfort</h3>
            <p>Quiet mini-split and multi-zone options help cool the rooms you actually use, with less wasted energy and better comfort control.</p>
          </article>
          <article>
            <span>03</span>
            <h3>Warranty confidence</h3>
            <p>Strong warranty programs, including 12-year options and Gecko warranty messaging, make Fujitsu easier to choose long term.</p>
          </article>
          <article>
            <span>04</span>
            <h3>Local support behind the brand</h3>
            <p>Admor supports Hawaii contractors with local product knowledge, inventory, parts access, and training resources.</p>
          </article>
        </div>
        <div class=\"fujitsu-why__compare\">
          <div>
            <h3>Don’t just ask, “What AC can you install?”</h3>
            <p>Ask your contractor: “Can you quote Fujitsu, and can you explain why it is the right fit for my home?”</p>
          </div>
          <div class=\"fujitsu-actions\">
            <a class=\"btn-main\" href=\"/find-a-fujitsu-contractor\">Find a Fujitsu Dealer</a>
            <a class=\"btn-main btn-outline\" href=\"/products\">Explore Fujitsu Products</a>
            <a class=\"btn-main btn-outline\" href=\"/fujitsu-vs-mitsubishi\">Compare Fujitsu to Other Brands</a>
            <a class=\"btn-main btn-outline\" href=\"/why-fujitsu-hawaii\">Why Fujitsu for Hawaii</a>
          </div>
        </div>
      </div>
    </section>

    ";
        // line 147
        if ((($tmp = ($context["homepage_slides"] ?? null)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
            // line 148
            yield "      <section class=\"fujitsu-pull fujitsu-pull--featured\">
        <div class=\"container\">
          <div class=\"fujitsu-section-heading\">
            <p class=\"fujitsu-eyebrow\">Featured Fujitsu stories</p>
            <h2>Comfort, rebates, warranty confidence, and Hawaii community support.</h2>
            <p>Explore the local proof points that help homeowners and businesses choose Fujitsu before the estimate is written.</p>
          </div>
          <div class=\"fujitsu-managed-grid fujitsu-managed-grid--slides\">
            ";
            // line 156
            $context['_parent'] = $context;
            $context['_seq'] = CoreExtension::ensureTraversable(($context["homepage_slides"] ?? null));
            foreach ($context['_seq'] as $context["_key"] => $context["slide"]) {
                // line 157
                yield "              <article class=\"fujitsu-story-card\">
                ";
                // line 158
                if ((($tmp = CoreExtension::getAttribute($this->env, $this->source, $context["slide"], "image", [], "any", false, false, true, 158)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
                    // line 159
                    yield "                  <img src=\"";
                    yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, $context["slide"], "image", [], "any", false, false, true, 159), "html", null, true);
                    yield "\" alt=\"";
                    yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, $context["slide"], "title", [], "any", false, false, true, 159), "html", null, true);
                    yield "\">
                ";
                }
                // line 161
                yield "                <h3>";
                yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, $context["slide"], "title", [], "any", false, false, true, 161), "html", null, true);
                yield "</h3>
                <p>";
                // line 162
                yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, $context["slide"], "summary", [], "any", false, false, true, 162), "html", null, true);
                yield "</p>
                <a href=\"";
                // line 163
                yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, $context["slide"], "link", [], "any", false, false, true, 163), "html", null, true);
                yield "\">";
                yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, $context["slide"], "link_text", [], "any", false, false, true, 163), "html", null, true);
                yield "</a>
              </article>
            ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_key'], $context['slide'], $context['_parent']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 166
            yield "          </div>
        </div>
      </section>
    ";
        }
        // line 170
        yield "
    ";
        // line 171
        if ((($tmp = ($context["homepage_branch_locations"] ?? null)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
            // line 172
            yield "      <section class=\"fujitsu-contractor-flow\">
        <div class=\"container\">
          <div class=\"fujitsu-section-heading fujitsu-section-heading--left\">
            <p class=\"fujitsu-eyebrow\">Local inventory and support</p>
            <h2>Fujitsu is backed here in Hawaii.</h2>
            <p>Local distribution support keeps contractors connected to product knowledge, equipment availability, and parts when Hawaii customers need them.</p>
          </div>
          <div class=\"fujitsu-flow-grid fujitsu-flow-grid--locations\">
            ";
            // line 180
            $context['_parent'] = $context;
            $context['_seq'] = CoreExtension::ensureTraversable(($context["homepage_branch_locations"] ?? null));
            $context['loop'] = [
              'parent' => $context['_parent'],
              'index0' => 0,
              'index'  => 1,
              'first'  => true,
            ];
            if (is_array($context['_seq']) || (is_object($context['_seq']) && $context['_seq'] instanceof \Countable)) {
                $length = count($context['_seq']);
                $context['loop']['revindex0'] = $length - 1;
                $context['loop']['revindex'] = $length;
                $context['loop']['length'] = $length;
                $context['loop']['last'] = 1 === $length;
            }
            foreach ($context['_seq'] as $context["_key"] => $context["branch"]) {
                // line 181
                yield "              <div>
                <strong>";
                // line 182
                yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, $context["loop"], "index", [], "any", false, false, true, 182), "html", null, true);
                yield "</strong>
                <h3>";
                // line 183
                yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, $context["branch"], "title", [], "any", false, false, true, 183), "html", null, true);
                yield "</h3>
                ";
                // line 184
                if ((($tmp = CoreExtension::getAttribute($this->env, $this->source, $context["branch"], "address", [], "any", false, false, true, 184)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
                    yield "<p>";
                    yield $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar(CoreExtension::getAttribute($this->env, $this->source, $context["branch"], "address", [], "any", false, false, true, 184));
                    yield "</p>";
                }
                // line 185
                yield "                ";
                if ((($tmp = CoreExtension::getAttribute($this->env, $this->source, $context["branch"], "phone", [], "any", false, false, true, 185)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
                    yield "<p><b>Phone:</b> ";
                    yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, $context["branch"], "phone", [], "any", false, false, true, 185), "html", null, true);
                    yield "</p>";
                }
                // line 186
                yield "                ";
                if ((($tmp = CoreExtension::getAttribute($this->env, $this->source, $context["branch"], "fax", [], "any", false, false, true, 186)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
                    yield "<p><b>Fax:</b> ";
                    yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, $context["branch"], "fax", [], "any", false, false, true, 186), "html", null, true);
                    yield "</p>";
                }
                // line 187
                yield "                <a class=\"btn-main\" href=\"";
                yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, $context["branch"], "link", [], "any", false, false, true, 187), "html", null, true);
                yield "\">";
                yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, $context["branch"], "link_text", [], "any", false, false, true, 187), "html", null, true);
                yield "</a>
              </div>
            ";
                ++$context['loop']['index0'];
                ++$context['loop']['index'];
                $context['loop']['first'] = false;
                if (isset($context['loop']['revindex0'], $context['loop']['revindex'])) {
                    --$context['loop']['revindex0'];
                    --$context['loop']['revindex'];
                    $context['loop']['last'] = 0 === $context['loop']['revindex0'];
                }
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_key'], $context['branch'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 190
            yield "          </div>
        </div>
      </section>
    ";
        }
        // line 194
        yield "
    <section class=\"fujitsu-feature-band\">
      <div class=\"container\">
        <div class=\"row g-4 align-items-center\">
          <div class=\"col-lg-7\">
            <p class=\"fujitsu-eyebrow\">Trust, warranty, rebates</p>
            ";
        // line 200
        if ((($tmp = ($context["warranty_cta"] ?? null)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
            // line 201
            yield "              ";
            yield $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar(CoreExtension::getAttribute($this->env, $this->source, ($context["warranty_cta"] ?? null), "body", [], "any", false, false, true, 201));
            yield "
            ";
        } else {
            // line 203
            yield "              <h2>Premium comfort should feel like a safe decision.</h2>
              <p>Strong warranty messaging and Hawaii Energy rebate opportunities make Fujitsu easier to choose.</p>
            ";
        }
        // line 206
        yield "          </div>
          <div class=\"col-lg-5\">
            <div class=\"fujitsu-feature-card\">
              ";
        // line 209
        if ((($tmp = ($context["award_cta"] ?? null)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
            // line 210
            yield "                ";
            yield $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar(CoreExtension::getAttribute($this->env, $this->source, ($context["award_cta"] ?? null), "body", [], "any", false, false, true, 210));
            yield "
                <a class=\"btn-main\" href=\"";
            // line 211
            yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, ($context["award_cta"] ?? null), "link", [], "any", false, false, true, 211), "html", null, true);
            yield "\">";
            yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, ($context["award_cta"] ?? null), "link_text", [], "any", false, false, true, 211), "html", null, true);
            yield "</a>
              ";
        } else {
            // line 213
            yield "                <h3>Best of Hawaii trusted comfort</h3>
                <p>Local recognition and familiar Fujitsu stories build confidence before the estimate.</p>
              ";
        }
        // line 216
        yield "            </div>
          </div>
        </div>
      </div>
    </section>

    <section class=\"fujitsu-stories js-fujitsu-proof\">
      <div class=\"container\">
        <div class=\"fujitsu-section-heading\">
          <p class=\"fujitsu-eyebrow\">Start here</p>
          <h2>Three easy paths into Fujitsu.</h2>
          <p>Commercials build familiarity, updates build trust, and the contractor flow turns demand into the next estimate.</p>
        </div>
        <div class=\"row g-4\">
          <div class=\"col-md-4\">
            <article class=\"fujitsu-story-card\">
              <img src=\"/sites/default/files/commercials/fujitsu-girl-growing-up.jpg\" alt=\"Fujitsu commercial preview\">
              <h3>Fujitsu Commercials</h3>
              <p>Watch the local commercials that keep Fujitsu familiar across Hawaii.</p>
              <a href=\"/commercials\">Watch commercials</a>
            </article>
          </div>
          <div class=\"col-md-4\">
            <article class=\"fujitsu-story-card\">
              <img src=\"/sites/default/files/wordpress-featured/fujitsu-hawaii-on-khon2.jpg\" alt=\"Fujitsu Hawaii update\">
              <h3>Updates</h3>
              <p>Browse news, rebates, community support, and local Fujitsu proof points.</p>
              <a href=\"/updates\">Read updates</a>
            </article>
          </div>
          <div class=\"col-md-4\">
            <article class=\"fujitsu-story-card\">
              <img src=\"/sites/default/files/wordpress-featured/find-a-fujitsu-contractor.png\" alt=\"Find a Fujitsu contractor\">
              <h3>Find a Fujitsu Dealer</h3>
              <p>Choose your island and ask for Fujitsu before the estimate is written.</p>
              <a href=\"/find-a-fujitsu-contractor\">Find a dealer</a>
            </article>
          </div>
        </div>
      </div>
    </section>

    ";
        // line 258
        if ((($tmp = ($context["call_cta"] ?? null)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
            // line 259
            yield "      <section class=\"fujitsu-cta-strip\">
        <div class=\"container\">
          <div class=\"fujitsu-cta-strip__inner\">
            ";
            // line 262
            yield $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar(CoreExtension::getAttribute($this->env, $this->source, ($context["call_cta"] ?? null), "body", [], "any", false, false, true, 262));
            yield "
            <a class=\"btn-main\" href=\"";
            // line 263
            yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, ($context["call_cta"] ?? null), "link", [], "any", false, false, true, 263), "html", null, true);
            yield "\">";
            yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, ($context["call_cta"] ?? null), "link_text", [], "any", false, false, true, 263), "html", null, true);
            yield "</a>
          </div>
        </div>
      </section>
    ";
        }
        // line 268
        yield "
    ";
        // line 269
        if ((($tmp = ($context["homepage_latest_news"] ?? null)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
            // line 270
            yield "      <section class=\"fujitsu-resources\">
        <div class=\"container\">
          <div class=\"fujitsu-section-heading\">
            <p class=\"fujitsu-eyebrow\">Latest news</p>
            <h2>Fresh reasons to choose Fujitsu.</h2>
            <p>Follow rebates, local stories, warranty updates, and practical guidance that make Fujitsu easier to request with confidence.</p>
          </div>
          <div class=\"fujitsu-managed-grid\">
            ";
            // line 278
            $context['_parent'] = $context;
            $context['_seq'] = CoreExtension::ensureTraversable(($context["homepage_latest_news"] ?? null));
            foreach ($context['_seq'] as $context["_key"] => $context["item"]) {
                // line 279
                yield "              <article class=\"fujitsu-story-card\">
                ";
                // line 280
                if ((($tmp = CoreExtension::getAttribute($this->env, $this->source, $context["item"], "image", [], "any", false, false, true, 280)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
                    yield "<img src=\"";
                    yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, $context["item"], "image", [], "any", false, false, true, 280), "html", null, true);
                    yield "\" alt=\"";
                    yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, $context["item"], "title", [], "any", false, false, true, 280), "html", null, true);
                    yield "\">";
                }
                // line 281
                yield "                <h3>";
                yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, $context["item"], "title", [], "any", false, false, true, 281), "html", null, true);
                yield "</h3>
                <p>";
                // line 282
                yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, $context["item"], "summary", [], "any", false, false, true, 282), "html", null, true);
                yield "</p>
                <a href=\"";
                // line 283
                yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, $context["item"], "url", [], "any", false, false, true, 283), "html", null, true);
                yield "\">Read update</a>
              </article>
            ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_key'], $context['item'], $context['_parent']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 286
            yield "          </div>
        </div>
      </section>
    ";
        }
        // line 290
        yield "
    ";
        // line 291
        if ((($tmp = ($context["homepage_faces"] ?? null)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
            // line 292
            yield "      <section class=\"fujitsu-home-faces\">
        <div class=\"container\">
          <div class=\"fujitsu-section-heading\">
            <p class=\"fujitsu-eyebrow\">Faces of Fujitsu</p>
            <h2>Familiar Hawaii voices help make Fujitsu the brand people request.</h2>
            <p>Local ambassadors and community stories help connect premium comfort with the people and places Hawaii already knows.</p>
          </div>
          <div class=\"fujitsu-face-strip\">
            ";
            // line 300
            $context['_parent'] = $context;
            $context['_seq'] = CoreExtension::ensureTraversable(($context["homepage_faces"] ?? null));
            foreach ($context['_seq'] as $context["_key"] => $context["face"]) {
                // line 301
                yield "              <a href=\"";
                yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, $context["face"], "url", [], "any", false, false, true, 301), "html", null, true);
                yield "\">
                ";
                // line 302
                if ((($tmp = CoreExtension::getAttribute($this->env, $this->source, $context["face"], "image", [], "any", false, false, true, 302)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
                    yield "<img src=\"";
                    yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, $context["face"], "image", [], "any", false, false, true, 302), "html", null, true);
                    yield "\" alt=\"";
                    yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, $context["face"], "title", [], "any", false, false, true, 302), "html", null, true);
                    yield "\">";
                }
                // line 303
                yield "                <strong>";
                yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, $context["face"], "title", [], "any", false, false, true, 303), "html", null, true);
                yield "</strong>
              </a>
            ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_key'], $context['face'], $context['_parent']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 306
            yield "          </div>
          <div class=\"fujitsu-centered-action\">
            <a class=\"btn-main\" href=\"/friends-family\">Meet all Faces of Fujitsu</a>
          </div>
        </div>
      </section>
    ";
        }
        // line 313
        yield "
    ";
        // line 314
        if ((($tmp = ($context["homepage_testimonials"] ?? null)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
            // line 315
            yield "      <section class=\"ilf-testimonials\">
        <div class=\"container\">
          <div class=\"fujitsu-section-heading\">
            <p class=\"fujitsu-eyebrow\">Customer proof</p>
            <h2>Hawaii buyers choose Fujitsu for comfort they can feel.</h2>
          </div>
          <div class=\"ilf-testimonials__grid\">
            ";
            // line 322
            $context['_parent'] = $context;
            $context['_seq'] = CoreExtension::ensureTraversable(($context["homepage_testimonials"] ?? null));
            foreach ($context['_seq'] as $context["_key"] => $context["item"]) {
                // line 323
                yield "              <article>
                <p>“";
                // line 324
                yield ((CoreExtension::getAttribute($this->env, $this->source, $context["item"], "quote", [], "any", false, false, true, 324)) ? ($this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, $context["item"], "quote", [], "any", false, false, true, 324), "html", null, true)) : ($this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, $context["item"], "summary", [], "any", false, false, true, 324), "html", null, true)));
                yield "”</p>
                <strong>";
                // line 325
                yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, $context["item"], "title", [], "any", false, false, true, 325), "html", null, true);
                yield "</strong>
                ";
                // line 326
                if ((CoreExtension::getAttribute($this->env, $this->source, $context["item"], "island", [], "any", false, false, true, 326) || CoreExtension::getAttribute($this->env, $this->source, $context["item"], "system", [], "any", false, false, true, 326))) {
                    yield "<span>";
                    yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, $context["item"], "island", [], "any", false, false, true, 326), "html", null, true);
                    if ((CoreExtension::getAttribute($this->env, $this->source, $context["item"], "island", [], "any", false, false, true, 326) && CoreExtension::getAttribute($this->env, $this->source, $context["item"], "system", [], "any", false, false, true, 326))) {
                        yield " / ";
                    }
                    yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, $context["item"], "system", [], "any", false, false, true, 326), "html", null, true);
                    yield "</span>";
                }
                // line 327
                yield "              </article>
            ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_key'], $context['item'], $context['_parent']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 329
            yield "          </div>
        </div>
      </section>
    ";
        }
        // line 333
        yield "
    <section class=\"fujitsu-contractor-flow\">
      <div class=\"container\">
        <div class=\"row g-5 align-items-center\">
          <div class=\"col-lg-5\">
            <p class=\"fujitsu-eyebrow\">Dealer regions</p>
            <h2>Find Fujitsu support by island.</h2>
            <p>Choose your island, connect with the right contractor pathway, and ask for Fujitsu by name during your estimate.</p>
          </div>
          <div class=\"col-lg-7\">
            <div class=\"fujitsu-resource-grid\">
              ";
        // line 344
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable(($context["homepage_dealer_regions"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["region"]) {
            // line 345
            yield "                <a href=\"";
            yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, $context["region"], "url", [], "any", false, false, true, 345), "html", null, true);
            yield "\">";
            yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, $context["region"], "title", [], "any", false, false, true, 345), "html", null, true);
            yield "</a>
              ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_key'], $context['region'], $context['_parent']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 347
        yield "            </div>
          </div>
        </div>
      </div>
    </section>

    ";
        // line 353
        if ((($context["instagram_cta"] ?? null) || ($context["homepage_donation_causes"] ?? null))) {
            // line 354
            yield "      <section class=\"fujitsu-resources\">
        <div class=\"container\">
          <div class=\"row g-5 align-items-center\">
            <div class=\"col-lg-5\">
              <p class=\"fujitsu-eyebrow\">Community and social proof</p>
              ";
            // line 359
            if ((($tmp = ($context["instagram_cta"] ?? null)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
                // line 360
                yield "                ";
                yield $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar(CoreExtension::getAttribute($this->env, $this->source, ($context["instagram_cta"] ?? null), "body", [], "any", false, false, true, 360));
                yield "
                <a class=\"btn-main\" href=\"";
                // line 361
                yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, ($context["instagram_cta"] ?? null), "link", [], "any", false, false, true, 361), "html", null, true);
                yield "\">";
                yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, ($context["instagram_cta"] ?? null), "link_text", [], "any", false, false, true, 361), "html", null, true);
                yield "</a>
              ";
            }
            // line 363
            yield "            </div>
            <div class=\"col-lg-7\">
              <div class=\"fujitsu-resource-grid\">
                ";
            // line 366
            $context['_parent'] = $context;
            $context['_seq'] = CoreExtension::ensureTraversable(($context["homepage_donation_causes"] ?? null));
            foreach ($context['_seq'] as $context["_key"] => $context["cause"]) {
                // line 367
                yield "                  <a href=\"";
                yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, $context["cause"], "link", [], "any", false, false, true, 367), "html", null, true);
                yield "\">";
                yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, $context["cause"], "title", [], "any", false, false, true, 367), "html", null, true);
                yield "</a>
                ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_key'], $context['cause'], $context['_parent']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 369
            yield "                <a href=\"/resources\">Product resources</a>
                <a href=\"/tech-tips\">Tech tips</a>
              </div>
            </div>
          </div>
        </div>
      </section>
    ";
        }
        // line 377
        yield "  </main>

  ";
        // line 379
        yield from $this->load("@ilovemyfujitsu/includes/footer.html.twig", 379)->unwrap()->yield($context);
        // line 380
        yield "</div>
<div class=\"ilf-sticky-cta\" role=\"region\" aria-label=\"Find a Fujitsu dealer\">
  <span>Ready to choose Fujitsu?</span>
  <a class=\"btn-main\" href=\"/find-a-fujitsu-contractor\">Find a Fujitsu Dealer Near You</a>
</div>
";
        $this->env->getExtension('\Drupal\Core\Template\TwigExtension')
            ->checkDeprecations($context, ["homepage_ctas", "homepage_slides", "theme_path", "homepage_branch_locations", "loop", "homepage_latest_news", "homepage_faces", "homepage_testimonials", "homepage_dealer_regions", "homepage_donation_causes"]);        yield from [];
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName(): string
    {
        return "themes/custom/ilovemyfujitsu/templates/layout/page--front.html.twig";
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
        return array (  746 => 380,  744 => 379,  740 => 377,  730 => 369,  719 => 367,  715 => 366,  710 => 363,  703 => 361,  698 => 360,  696 => 359,  689 => 354,  687 => 353,  679 => 347,  668 => 345,  664 => 344,  651 => 333,  645 => 329,  638 => 327,  628 => 326,  624 => 325,  620 => 324,  617 => 323,  613 => 322,  604 => 315,  602 => 314,  599 => 313,  590 => 306,  580 => 303,  572 => 302,  567 => 301,  563 => 300,  553 => 292,  551 => 291,  548 => 290,  542 => 286,  533 => 283,  529 => 282,  524 => 281,  516 => 280,  513 => 279,  509 => 278,  499 => 270,  497 => 269,  494 => 268,  484 => 263,  480 => 262,  475 => 259,  473 => 258,  429 => 216,  424 => 213,  417 => 211,  412 => 210,  410 => 209,  405 => 206,  400 => 203,  394 => 201,  392 => 200,  384 => 194,  378 => 190,  358 => 187,  351 => 186,  344 => 185,  338 => 184,  334 => 183,  330 => 182,  327 => 181,  310 => 180,  300 => 172,  298 => 171,  295 => 170,  289 => 166,  278 => 163,  274 => 162,  269 => 161,  261 => 159,  259 => 158,  256 => 157,  252 => 156,  242 => 148,  240 => 147,  184 => 93,  178 => 91,  170 => 89,  168 => 88,  165 => 87,  163 => 86,  148 => 76,  145 => 75,  141 => 73,  135 => 71,  133 => 70,  124 => 63,  121 => 62,  118 => 61,  115 => 60,  112 => 59,  109 => 58,  106 => 57,  104 => 56,  100 => 54,  98 => 53,  44 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("", "themes/custom/ilovemyfujitsu/templates/layout/page--front.html.twig", "/private/tmp/ilovemyfujitsu-drupal/web/themes/custom/ilovemyfujitsu/templates/layout/page--front.html.twig");
    }
    
    public function checkSecurity()
    {
        static $tags = ["include" => 53, "set" => 56, "if" => 70, "for" => 156];
        static $filters = ["raw" => 71, "escape" => 76, "default" => 76, "first" => 86];
        static $functions = [];

        try {
            $this->sandbox->checkSecurity(
                ['include', 'set', 'if', 'for'],
                ['raw', 'escape', 'default', 'first'],
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

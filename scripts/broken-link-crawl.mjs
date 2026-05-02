#!/usr/bin/env node

const base = process.argv[2] || 'http://127.0.0.1:8097';
const origin = new URL(base).origin;
const seenPages = new Set();
const checked = new Map();
const broken = [];

function normalize(url, from = base) {
  try {
    while (url.includes('&amp;')) {
      url = url.replaceAll('&amp;', '&');
    }
    const next = new URL(url, from);
    if (['mailto:', 'tel:', 'javascript:'].includes(next.protocol)) return null;
    next.hash = '';
    return next.toString();
  }
  catch {
    return null;
  }
}

async function status(url) {
  if (checked.has(url)) return checked.get(url);
  const controller = new AbortController();
  const timeout = setTimeout(() => controller.abort(), 10000);
  let result = 0;
  try {
    let response = await fetch(url, { method: 'HEAD', redirect: 'follow', signal: controller.signal });
    if (response.status === 405 || response.status === 403) {
      response = await fetch(url, { method: 'GET', redirect: 'follow', signal: controller.signal });
    }
    result = response.status;
  }
  catch {
    result = 0;
  }
  clearTimeout(timeout);
  checked.set(url, result);
  return result;
}

async function body(url) {
  const response = await fetch(url, { redirect: 'follow' });
  return response.text();
}

function links(html, from) {
  const found = new Set();
  for (const match of html.matchAll(/\s(?:href|src)=["']([^"']+)["']/gi)) {
    const href = normalize(match[1], from);
    if (href) found.add(href);
  }
  return [...found];
}

async function crawlPage(url) {
  if (seenPages.has(url)) return;
  seenPages.add(url);
  const code = await status(url);
  if (code < 200 || code >= 400) {
    broken.push({ from: 'sitemap', url, code });
    return;
  }
  const html = await body(url);
  for (const href of links(html, url)) {
    const hrefUrl = new URL(href);
    if (hrefUrl.origin !== origin) {
      continue;
    }
    const code = await status(href);
    if (code < 200 || code >= 400) {
      broken.push({ from: url, url: href, code });
      continue;
    }
    const looksPage = !/\.(pdf|png|jpe?g|gif|webp|svg|ico|css|js|woff2?)$/i.test(hrefUrl.pathname);
    if (looksPage && !href.includes('amp%3B')) await crawlPage(href);
  }
}

const sitemap = await body(`${base.replace(/\/$/, '')}/sitemap.xml`);
const urls = [...sitemap.matchAll(/<loc>(.*?)<\/loc>/g)].map((m) => m[1].trim());
urls.unshift(base);
for (const url of urls) {
  const normalized = normalize(url);
  if (normalized && new URL(normalized).origin === origin) {
    await crawlPage(normalized);
  }
}

if (broken.length) {
  console.log('Broken links found:');
  for (const item of broken) {
    console.log(`${item.code} ${item.url} from ${item.from}`);
  }
  process.exitCode = 1;
}
else {
  console.log(`No broken local links found across ${seenPages.size} pages and ${checked.size} unique URLs.`);
}

# Twig Seo Bundle v0.1.0
> This is an older version of bundle extension, you can find latest version document [here](https://github.com/ahmetcelikezer/twig-seo-bundle/blob/master/Resources/doc/latest/README.md)

This bundle includes a twig extension to print SEO meta tags easily. This is an early version of bundle, new features will be added soon.
> Note: This is an early version of the extension bundle! The stable version will release soon. So next version(s) may not support this version's feature(s)!

## Installation
You can install this bundle with composer.
```bash
composer require ahc/twigseobundle "^0.1.0"
```

## Methods
* [Seo Base](#seo-base)
* [Seo Title](#seo-title)
* [Seo Description](#seo-description)
* [Seo Image](#seo-image)
* [Seo Page](#seo-page)
### Seo Base
This method print a basic tags.
```twig
{{ seoBase() }}
```
This method includes the following tags:
```html
<meta property="og:type" content="website" />
```
---
### Seo Title
This method print title tags with og title's. It takes only one string parameter to set the title.
```twig
{{ seoTitle('Your Title') }}
```
This method includes the following tags:
```html
<title>Your Title</title>
<meta property="og:site_name" content="Your Title">
<meta property="og:title" content="Your Title" />
<meta name="twitter:title" content="Your Title" />
```
---
### Seo Description
This method print a description tags. It takes only one string parameter to set the description.
```twig
{{ seoDescription('Description text...') }}
```
This method includes the following tags:
```html
<meta name="description" content="Description text...">
<meta property="og:description" content="Description text..." />
<meta name="twitter:description" content="Description text..." />
```
---
### Seo Image
This method print the og image tags. It takes only one string parameter for set absolute image path.
```twig
{{ seoImage('path/image_file') }}
```
> Warning! The image path must be a absolute path!!

This method includes the following tags:
```html
<meta property="og:image" content="path/image_file" />
<meta name="twitter:image" content="path/image_file" />
<link rel="image_src" href="path/image_file" />
```
---
### Seo Page
Sometimes every page has it's own meta tags. This method will set title and description of current page. It takes one array parameter including `title` and `description`.
```twig
{{ seoPage({ title: 'Page Title', description: 'Page Description' }) }}
```
The method includes the following tags:
```html
<title>Page Title</title>
<meta name="description" content="Page Description">
```





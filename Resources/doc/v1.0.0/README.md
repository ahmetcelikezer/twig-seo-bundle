# Twig Seo Bundle v1.0.0 Not Usable !!!

> Version 1 is buggy and not usable, use Version 2.0 instead!

> This version is a major and version and is not supported by the older version(s)!

This extension bundle is designed for automating to printing meta tags. You can use default meta tag groups defined by us or you can create your very own element groups with unlimited parameters to print them to your twig templates.
## Installation
You can install this bundle with composer.
```bash
composer require ahc/twigseobundle
```

## Instructions
- [Creating a Element Groups](#creating-custom-element-groups)
    - [Defining Element Groups](#an-example-to-create-custom-element-group)
    - [Calling Other Groups](#methods)
- [Default Element Groups](#default-element-groups)
    - [Base Elements](#base)
    - [Title Elements](#title)
    - [Description Elements](#description)
    - [Og Image Elements](#og-image)

## Creating Custom Element Groups
With this bundle, creating your own element groups to print with `seo_group` method. You can also customize the default element groups.

The meta groups can be defined under `ahc_twig_seo > groups` namespace in `ahc_twig_seo.yaml` file.

You can use these keys when you define or edit an meta group:

| Key           | Explanation                                                | Type  | Required  |
| ------------- | ---------------------------------------------------------- | ----- | --------- |
| arguments     | Determines the variables of the parameters in the tag.     | array | false     |
| tags          | Contains the elements of group has.                        | array | false     |
| methods       | Methods to call for print other defined or default groups. | array | false     |

### Group Keys
The keys that groups can contain. I will be explain each key over the example configuration.

Example Configuration:
```yaml
ahc_twig_seo:
  groups:
    # Our meta group
    example_group:
      arguments:
      title: '%%title%%'
      description: '%%description%%'
      imagePath: '%%image%%'
    tags:
      - '<title>%%title%%</title>'
      - '<meta property="og:site_name" content="%%title%%" />'
      - '<meta property="og:title" content="%%title%%" />'
      - '<meta name="twitter:title" content="%%title%%" />'
    methods: ['default_description', 'favicon_group']
  
    # Defined meta group
    favicon_group:
      arguments:
        imagePath: '%%image%%'
      tags:
        - '<meta property="og:image" content="%%image_path%%" />'
        - '<meta name="twitter:image" content="%%image_path%%" />'
        - '<link rel="image_src" href="%%image_path%%" />'
          
    # Default meta group
    default_description:
      arguments:
        description: '%%description%%'
      tags:
        - '<meta name="description" content="%%description%%" />'
        - '<meta property="og:description" content="%%description%%" />'
        - '<meta name="twitter:description" content="%%description%%" />'

```
##### arguments:
Keys are defined in this key contains parameters the variable replacement for variables the meta tags has. The key of array is used for set the data for it's value by twig method.

> Note: The key of value defined in arguments option have to be same with the twig method parameter.

For example, we want to print `favicon_group`, so we have to define the variable(s) in our group argument(s).
Favicon group only requires `imagePath` parameter. We can call it like:

```twig
    seo_group('favicon_group', { imagePath: 'path/of/image.jpg' })
```

Now all the tags which is contains `%%image%%` key will be replaced the `path/of/image.jpg` value.
 
output:
```html
    <link rel="image_src" href="path/of/image.jpg" />
    <meta name="twitter:image" content="path/of/image.jpg" />
    <link rel="image_src" href="path/of/image.jpg" />
```

###### an example to create custom element group:
you can define unlimited meta groups like that.

```yaml
ahc_twig_seo:                           # Root namespace for configuration of bundle. 
    groups:                             # Namespace to define meta groups.
      
      example_group:                    # Name that you want to set for the meta group.
        arguments:                      # Parameters array for the set to meta group.
          size: '%%size%%'
          image_path: '%%image_path%%'
          mime_type: '%%ext%%'
        tags:                           # Meta tags the defined meta group will have.
          - '<link rel="icon" type="%%ext%%" sizes="%%size%%" href="%%image_path%%">'

```
to print `example_group` defined like above, you can call it in your twig template:
```twig
    seo_group('example_group', { size: '16x16', image_path: 'img/assets/img/favicon.png', mime_type:'image/png' })
```

output will be:
```html
<link rel="icon" type="image/png" sizes="16x16" href="img/assets/img/favicon.png">
```

##### tags:
The html tags array to print. Html tags can have a parameter(s) to replace. It should be defined between double percent signs `%%`. For example in the example configuration `%%description%%` will be replaced the data given `description` variable defined inside `arguments` in the configuration.

##### methods:
It stores the group names to run before the tags replacement. Defined methods will be printed, bu you should define all the arguments for the group(s) requires.

For Example:
```yaml
ahc_twig_seo:
    groups:
      test_group:
        arguments:
          title: '%%title%%'
          description: '%%description%%'
        methods: ['default_title', 'default_description']

```
The group must contain arguments which the defined methods requires. This test_group will call `default_title` and `default_description` groups with parameters it takes.

```twig
    #seo_group([string]groupName, [json]arrayOfArguments)
    seo_group('test_group', { title: 'Example Title', description: 'Example Description' })
```

### Default Element Groups:
You can use default groups faster with their methods defined. However you can also customize all data default group has.

To customize default groups, you can define them in `ahc_twig_seo.yaml` configuration using its group name just like you are defining brand new group but it will be overwritten with your customization.

##### Base
| Method Name   | Group Name    | Required Arguments |
| ------------- | ------------- |------------------- |
| seo_base      | default_base  | NULL               |

```twig
    seo_base()
```
This method will be print the group ```default_base```
Default Tags the Group Has:
```html
    <meta charset="utf-8">
    <meta property="og:type" content="website" />
    <meta content="IE=edge" http-equiv="X-UA-Compatible" />
    <meta content="width=device-width, initial-scale=1" name="viewport" />
```
---
##### Title
| Method Name   | Group Name    | Required Arguments |
| ------------- | ------------- |------------------- |
| seo_title     | default_title | (string)title      |

```twig
    seo_title('Example Title')
```
This method will be print the group ```default_title```
Default Tags the Group Has:
```html
    <title>%%title%%</title>
    <meta property="og:site_name" content="%%title%%">
    <meta property="og:title" content="%%title%%" />
    <meta name="twitter:title" content="%%title%%" />
```
> The parameters between the `%%` will be replaced with the given parameter in method.
---
##### Description
| Method Name     | Group Name           | Required Arguments  |
| --------------- | -------------------- |-------------------- |
| seo_description | default_description  | (string)description |

```twig
    seo_description('Example Description')
```
This method will be print the group ```default_description```
Default Tags the Group Has:
```html
    <meta name="description" content="%%description%%" />
    <meta property="og:description" content="%%description%%" />
    <meta name="twitter:description" content="%%description%%" />
    <meta content="width=device-width, initial-scale=1" name="viewport" />
```
> The parameters between the `%%` will be replaced with the given parameter in method.
---
##### Og Image
| Method Name   | Group Name        | Required Arguments |
| ------------- | ----------------- |------------------- |
| seo_image     | default_og_images | (string)imagePath  |

```twig
    seo_image('absolute/path/to/img.jpg')
```
This method will be print the group ```default_og_images```
Default Tags the Group Has:
```html
    <meta property="og:image" content="%%image_path%%" />
    <meta name="twitter:image" content="%%image_path%%" />
    <link rel="image_src" href="%%image_path%%" />
```
> The parameters between the `%%` will be replaced with the given parameter in method.

## Next Version Planned Features
1. Loop able arguments for same tag(s).



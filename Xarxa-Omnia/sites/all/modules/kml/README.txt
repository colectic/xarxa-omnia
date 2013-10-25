
# KML Module

The KML module provides a Views plugin that can format nodes, users, or 
any other data source in Drupal as a KML feed, accessible by Google Earth 
or web maps like OpenLayers and Google Maps.

http://drupal.org/project/kml


## Requirements

* Views (http://drupal.org/project/views)


## Installation

* Install & enable the module. See http://drupal.org/node/70151 for help.


## Usage

1. Add a Feed display to a View that handles nodes (or other data) that include
   locative infomation.
2. Add fields for the Name, Description, Latitude and Longitude for each point.
3. Set the display's Style to KML Feed.
4. Configure the KML Feed's Style Options, choosing the appropriate fields and
   optionally choosing a Filename for the downloadble file.
5. Optionally attach the feed display to another display.


## Outputting other fields

Fields included in the View that are not assigned as Name, Description,
Latitude, or Longitude in KML's style settings are made available as preprocess
variables via template_preprocess_kml_placemark() that can be used in custom
theme implementations of kml-placemark.tpl.php.

Each field is made available as $content['VARNAME'], where the VARNAME of the
field can be found in Views' field-rewriting token listing, or via
print_r($content);


## Customization

KML feeds can be customized thoroughly by overriding theme functions and files
in custom themes. They cannot, however, be customized through the Drupal UI.

See theme functions in kml.module for reference here - adding a preprocess to
the kml_placemark and kml_style theme function will allow for behaviors like
scaled points and more.


## Credits

* [raintonr](http://drupal.org/user/27877)
* [geodan](http://drupal.org/user/37266)
* [rsoden](http://drupal.org/user/226437)
* [tmcw](http://drupal.org/user/12664)
* [jeffschuler](http://drupal.org/user/239714)

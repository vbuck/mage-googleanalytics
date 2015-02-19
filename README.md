# Vbuck_GoogleAnalytics

An experimental rewrite of `Mage_GoogleAnalytics` to provide more features to developers.

Objectives:

* Utilize templates for all parts of the GA process
* Expose a block to developers for custom tracking code injection prior to beacon dispatch.

This module is a work-in-progress. I think ideally I'd like to see the GA configuration data
converted to an object that can be passed via event observer. Or, at least, adjust the module
as is to use layout XML for block declarations.
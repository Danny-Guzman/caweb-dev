# CAWebPublishing Development Toolbox
This plugin extends the [WordPress Rest API](https://developer.wordpress.org/rest-api/) and adds a powerful IDE built with [CodeMirror](https://codemirror.net/) to allow developers to quickly run PHP and SQL commands in realtime. 

## How to use this plugin
- Install and enable this plugin
- Keep the plugin up-to-date for important security updates.
- Check our CHANGELOG for notifications of major updates.

## Dependencies
- Requires WordPress 6.4 or greater.
- Requires PHP 8.2 or greater

## API Endpoints

`/wp-json/caweb/v1/sync` - Allows for updating taxonomy ID's.
  
Request Parameters:  
- id - Current ID to be updated.
- newId - New ID to replace current.
- tax - Taxonomy to be upated. Available taxonomies include pages, posts, media, menus.
- locations - Only if tax is menus, allows assigning a menu to a registered location.  

Requst Example:  
<pre>
{  
    method: 'POST',  
    url: 'http://example.com/wp-json/caweb/v1/sync',  
    headers: {  
        'Authorization': <a href="https://developer.wordpress.org/rest-api/using-the-rest-api/authentication/">Authentication Method</a>,  
        'content-type': 'multipart/form-data',  
        'accept': '*/*',  
    },  
    data: {  
        id: 1,    
        newId: 10,    
        tax: 'pages', // Allowed taxonomies include 
        locations: ['header-menu'], // This parameter is only used for menus and     
    },  
}
</pre>                
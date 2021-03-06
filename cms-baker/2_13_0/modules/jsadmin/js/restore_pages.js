// Copyright 2006 Stepan Riha
// www.nonplus.net
// $Id: restore_pages.js 65 2017-03-03 21:38:16Z manu $
//
/*
var elem  = document.getElementsByClassName('page_tree');
    for(var i = 0; i < elem.length; i++) {
console.info(elem[i]);
    }
*/
// Array of ids that can be toggled using toggle_visibility()
JsAdmin.toggled_ids = function() {
    var links = document.getElementsByTagName('a');
//    var links  = document.getElementsByClassName('page_tree');
    var ids = [];
    var reId = /toggle_visibility\s*\(\s*\'([^\']+)/;

    for(var i = 0; i < links.length; i++) {
        var href = links[i].href || '';
//console.info(href);
        var match = href.match(reId);
//console.log(links[i]);
        if(!match) { continue; }
        var id = match[1];
        ids.push(id);
    }
    if(ids.length > 0) {
        return ids;
    } else {
        return false;
    }
};

// Expand sections stored in the wb_jsadmin_pages cookie
JsAdmin.restore_toggled = function() {
    var ids = this.toggled_ids();
    if(!ids) { return; }
    var saved = this.util.readCookie('wb_jsadmin_pages');
//console.log('[039] readCookie: '+saved);
    if(!saved) { return;}
    var reNum = /(\d+)/;
    saved = ',' + saved + ',';
    for(var i = ids.length-1; i >= 0; i--) {
        var id = ids[i];
        if(saved.indexOf(',' + id + ',') >= 0) {
            toggle_visibility(id);
            var match = id.match(reNum);
            if(match){
                toggle_plus_minus(match[1]);
            }
        }
    }
};

// Store expanded section ids in the wb_jsadmin_pages cookie
JsAdmin.save_toggled = function() {
    var ids = this.toggled_ids();
    if(!ids) {
        return;
    }
    var visible = [];
    for(var i = 0; i < ids.length; i++) {
        var id = ids[i];
        var elt = YAHOO.util.Dom.get(id);
        var display = elt.style.display;
        if(display == 'block') {
            visible.push(ids[i]);
        }
    }

    var ids = visible.join(",");
    this.util.createCookie('wb_jsadmin_pages', ids, 14);
};


!function(e){var t={};function r(o){if(t[o])return t[o].exports;var n=t[o]={i:o,l:!1,exports:{}};return e[o].call(n.exports,n,n.exports,r),n.l=!0,n.exports}r.m=e,r.c=t,r.d=function(e,t,o){r.o(e,t)||Object.defineProperty(e,t,{enumerable:!0,get:o})},r.r=function(e){"undefined"!=typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(e,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(e,"__esModule",{value:!0})},r.t=function(e,t){if(1&t&&(e=r(e)),8&t)return e;if(4&t&&"object"==typeof e&&e&&e.__esModule)return e;var o=Object.create(null);if(r.r(o),Object.defineProperty(o,"default",{enumerable:!0,value:e}),2&t&&"string"!=typeof e)for(var n in e)r.d(o,n,function(t){return e[t]}.bind(null,n));return o},r.n=function(e){var t=e&&e.__esModule?function(){return e.default}:function(){return e};return r.d(t,"a",t),t},r.o=function(e,t){return Object.prototype.hasOwnProperty.call(e,t)},r.p="/",r(r.s=163)}({163:function(e,t,r){e.exports=r(164)},164:function(e,t){function r(e,t){for(var r=0;r<t.length;r++){var o=t[r];o.enumerable=o.enumerable||!1,o.configurable=!0,"value"in o&&(o.writable=!0),Object.defineProperty(e,o.key,o)}}var o=function(){function e(){!function(e,t){if(!(e instanceof t))throw new TypeError("Cannot call a class as a function")}(this,e)}var t,o,n;return t=e,(o=[{key:"init",value:function(){var e=$("#table-backups");e.on("click",".deleteDialog",(function(e){e.preventDefault(),$(".delete-crud-entry").data("section",$(e.currentTarget).data("section")),$(".modal-confirm-delete").modal("show")})),e.on("click",".restoreBackup",(function(e){e.preventDefault(),$("#restore-backup-button").data("section",$(e.currentTarget).data("section")),$("#restore-backup-modal").modal("show")})),$(".delete-crud-entry").on("click",(function(t){t.preventDefault(),$(".modal-confirm-delete").modal("hide");var r=$(t.currentTarget).data("section");$.ajax({url:r,type:"DELETE",success:function(t){t.error?Botble.showError(t.message):(e.find('a[data-section="'+r+'"]').closest("tr").remove(),Botble.showSuccess(t.message))},error:function(e){Botble.handleError(e)}})})),$("#restore-backup-button").on("click",(function(e){e.preventDefault();var t=$(e.currentTarget);t.addClass("button-loading"),$.ajax({url:t.data("section"),type:"GET",success:function(e){t.removeClass("button-loading"),t.closest(".modal").modal("hide"),e.error?Botble.showError(e.message):(Botble.showSuccess(e.message),window.location.reload())},error:function(e){t.removeClass("button-loading"),Botble.handleError(e)}})})),$(document).on("click","#generate_backup",(function(e){e.preventDefault(),$("#name").val(""),$("#description").val(""),$("#create-backup-modal").modal("show")})),$("#create-backup-modal").on("click","#create-backup-button",(function(t){t.preventDefault();var r=$(t.currentTarget);r.addClass("button-loading");var o=$("#name").val(),n=$("#description").val(),a=!1;""!==o&&null!==o||(a=!0,Botble.showError("Backup name is required!")),""!==n&&null!==n||(a=!0,Botble.showError("Backup description is required!")),a?r.removeClass("button-loading"):$.ajax({url:$("div[data-route-create]").data("route-create"),type:"POST",data:{name:o,description:n},success:function(t){r.removeClass("button-loading"),r.closest(".modal").modal("hide"),t.error?Botble.showError(t.message):(e.find(".no-backup-row").remove(),e.find("tbody").append(t.data),Botble.showSuccess(t.message))},error:function(e){r.removeClass("button-loading"),Botble.handleError(e)}})}))}}])&&r(t.prototype,o),n&&r(t,n),e}();$(document).ready((function(){(new o).init()}))}});
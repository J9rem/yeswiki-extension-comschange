/*
 * This file is part of the YesWiki Extension comschange.
 *
 * Authors : see README.md file that was distributed with this source code.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

function appendChar(target){
  let char = target.innerText;
  let form = target.parentNode;
  while (!['BODY','FORM'].includes(form.tagName)) {
    form = form.parentNode
  }
  if (form.tagName == "FORM"){
    let textArea = form.querySelector('textarea');
    if (textArea){
      let pos = textArea.selectionStart;
      if (typeof pos !== "number" || pos < 0){
        textArea.value += char
      } else {
        let oldValue = textArea.value
        textArea.value = oldValue.slice(0,pos)+char+oldValue.slice(pos);
        textArea.selectionStart = pos+1
        textArea.selectionEnd = pos+1
        textArea.focus();
      }
    }
  }
};

$(document).ready(function(){
  
  $(".comment-container #comment-block.collapse.comment-display").on ("click",function(){
    if (!$(this).hasClass('in') && $(this).hasClass('collapse') && $(this).hasClass('comment-display')){
      $(this).siblings('.comment-display-btn').click();
    }
  });  
  $(".comment-container #comment-block.collapse.comment-display a,.comment-container #comment-block.collapse.comment-display .btn").on ("click",function(){
    let parent = $(this).closest('.collapse');
    if (!$(parent).hasClass('in') && $(parent).hasClass('collapse') && $(parent).hasClass('comment-display')){
      $(parent).siblings('.comment-display-btn').click();
    }
  });
  $('.comment-container #comment-block').on("hide.bs.collapse", function(){
    $(this).siblings('.comment-display-btn').each(function(){
      $(this).find('.comment-display-btn-hide').hide();
      $(this).find('.comment-display-btn-see').show();
    });
  });
  $('.comment-container #comment-block').on("show.bs.collapse", function(){
    $(this).siblings('.comment-display-btn').each(function(){
      $(this).find('.comment-display-btn-see').css('display','none');
      $(this).find('.comment-display-btn-hide').css('display','');
    });
  });
});
/*
 * This file is part of the YesWiki Extension comschange.
 *
 * Authors : see README.md file that was distributed with this source code.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
// for comments table
$('#commentsTableDeleteModal.modal').on('shown.bs.modal',function(event){
  multiDeleteService.initProgressBar($(this));
  $(this).find('.modal-body .multi-delete-results').html('');
  let deleteButton = $(this).find('button.start-btn-delete-comment')
  $(deleteButton).removeAttr('disabled');
  let button = $(event.relatedTarget) // Button that triggered the modal
  let name = $(button).data('name');
  let csrfToken = $(button).closest('tr').find(`td > label > input[data-itemId=${name}][data-csrfToken]`).first().data('csrftoken');
  $(this).find('#commentToDelete').text(name);
  $(deleteButton).data('name',name);
  $(deleteButton).data('csrfToken',csrfToken);
  $(deleteButton).data('targetNode',button);
  $(deleteButton).data('modal',this);
  if (!$(deleteButton).hasClass('eventSet')){
    $(deleteButton).addClass('eventSet');
    $(deleteButton).on('click',function(){
      $(this).attr('disabled','disabled');
      $(this).tooltip('hide');
      let name = $(this).data('name');
      let csrfToken = $(this).data('csrfToken');
      let targetNode = $(this).data('targetNode');
      let modal = $(this).data('modal');
      
      $.ajax({
        method: 'get',
        url: wiki.url(`api/comments/${name}/delete`,{csrfToken:csrfToken}),
        timeout: 30000, // 30 seconds
        error: function (e) {
          multiDeleteService.addErrorMessage($(modal),
            _t('COMMENT_NOT_DELETED',{comment:name})+ ' : '
            +(e.responseJSON && e.responseJSON.error ? e.responseJSON.error : ''));
        },
        success: function(){
          multiDeleteService.removeLine($(targetNode).closest('.dataTables_wrapper').prop('id'),name);
          $(modal).find('.modal-body .multi-delete-results').first().append(
            $('<div>').text(_t('COMMENT_DELETED'))
          );
        },
        complete: function (){
          multiDeleteService.updateProgressBar($(modal),['test'],0);
        }
      });
    });
  }
});
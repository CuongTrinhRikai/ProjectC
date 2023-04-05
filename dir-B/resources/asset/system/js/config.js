$(document).ready(function () {
    cmsConfig.init()
  })
  
  const cmsConfig = (function () {
    const $typeSelector = $('select#type')
    const $fieldWrapper = $('#dynamic-field-wrapper')
    let htmlContents = {}
  
    const init = () => {
      registerEventListeners()
      getHtmlContents()
      populateWrapper($typeSelector.val())
    }
  
    const getHtmlContents = () => {
      $fieldWrapper.find('.col-auto').each((index, input) => {
        const content = $(input)
        htmlContents[content.attr('id')] = content
      })
      $fieldWrapper.removeClass('d-none').html('')
    }
  
    const registerEventListeners = () => {
      $typeSelector.on('change', handleTypeChange)
    }
  
    const handleTypeChange = function () {
      populateWrapper($(this).val())
    }
  
    const populateWrapper = type => {
      if (!!type) $fieldWrapper.html(htmlContents[`${type}-type`])
      else $fieldWrapper.html('')
    }
  
    return {
      init,
    }
  })()
  
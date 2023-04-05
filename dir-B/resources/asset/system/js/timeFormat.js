$(function () {
    timeFormat.init()
  })
  
  // Toggle visibility of application settings
  const timeFormat = (function () {
  
    const init = () => {
      attachEventListeners()
    }
  
    const attachEventListeners = () => {
      $('.localTime').each(function() {
        const date = $(this).html();
        const format = $(this).attr('format')
        console.log(moment.utc(date))
        const result = moment.utc(date).utcOffset(moment().format("Z")).format(format || "YYYY-MM-DD HH:mm:ss")
        // $(this).html(result)
        $(this).append('   '+result)
     });
    }
  
    return {
      init,
    }
  })()
  
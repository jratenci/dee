
$.fn.LoadingMessage = function (a)
{
	var attr, loading;
	$(this).click(function()
	{
		if(a.attr=='text')
		{ 
			if($(this).attr('title') !='' )
			{ 
				attr=$(this).attr('title'); 
			} 
			else 
			{ 
				attr=$(this).text();
			}
		}
		else if (a.attr=='url')
		{
			attr=$(this).attr('href');
		}
		loading = '<div id="'+a.css+'">'+a.text+' '+attr+'<\/div>';
		$('body').prepend(loading);
	});
	return false;
};

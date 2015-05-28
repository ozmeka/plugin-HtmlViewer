<?php

class HtmlViewerPlugin extends Omeka_Plugin_AbstractPlugin
{
	protected $_hooks = array('install', 'uninstall', 'admin_items_show', 'public_items_show');

//    protected $_filters = array();

	public function hookInstall()
	{
	}

	public function hookUninstall()
	{
	}
	
    public function hookAdminItemsShow($args)
    {
		$filesToDisplay = array();
		
		foreach($args['item']->Files as $file)
		{
			if ($file->mime_type == 'text/html')
			{
				$html = file_get_contents(FILES_DIR. '/'. $file->getStoragePath('original'));
				$html = $this->_extractHtmlBody($html);
				
				$filesToDisplay[$file['original_filename']] = $html;
			}
		}
		
		if ($filesToDisplay)
		{
			echo common('doctext-show', array(
				'files' => $filesToDisplay,
			));
		}
	}

    public function hookPublicItemsShow($args)
    {
		$filesToDisplay = array();
		
		foreach($args['item']->Files as $file)
		{
			if ($file->mime_type == 'text/html')
			{
				$html = file_get_contents(FILES_DIR. '/'. $file->getStoragePath('original'));
				$html = $this->_extractHtmlBody($html);
				
				$filesToDisplay[$file['original_filename']] = $html;
			}
		}
		
		if ($filesToDisplay)
		{
			echo common('doctext-show', array(
				'files' => $filesToDisplay,
			));
		}
	}
	
	protected function _extractHtmlBody($html)
	{
		// get anything between <body> and </body> where <body can="have_as many" attributes="as required">
		if (preg_match('/(?:<body[^>]*>)(.*)<\/body>/isU', $html, $matches)) {
			$body = $matches[1];
		}
		
		return trim($body);
	}
}
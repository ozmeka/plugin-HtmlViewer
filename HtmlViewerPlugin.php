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
		require_once('libraries/html5lib-php/library/HTML5/Parser.php');
		$dom = HTML5_Parser::parse($html);
		$xpath = new DOMXPath($dom);
		$body = $xpath->query('/html/body');
		$html = $dom->saveHTML($body->item(0));
		$innerHtml = $this->_domInnerHtml($dom->getElementsByTagName('body')->item(0));
		return trim($innerHtml);
	}
	
	protected function _domInnerHtml(DOMNode $element)
	{
		$innerHTML = "";
		foreach ($element->childNodes as $child)
		{ 
			$innerHTML .= $element->ownerDocument->saveHTML($child);
		}

	    return $innerHTML; 
	}
}
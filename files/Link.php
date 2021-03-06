<?php

class Link extends LinkCore
{

        /**
         * Returns a link to a product image for display
         * Note: the new image filesystem stores product images in subdirectories of img/p/
         *
         * @param string $name rewrite link of the image
         * @param string $ids id part of the image filename - can be "id_product-id_image" (legacy support, recommended) or "id_image" (new)
         * @param string $type
         */
        public function getImageLink($name, $ids, $type = null)
        {
                $not_default = false;
                // legacy mode or default image
                $theme = ((Shop::isFeatureActive() && file_exists(_PS_PROD_IMG_DIR_.$ids.($type ? '-'.$type : '').'-'.(int)Context::getContext()->shop->id_theme.'.jpg')) ? '-'.Context::getContext()->shop->id_theme : '');
                if ((Configuration::get('PS_LEGACY_IMAGES')
                        && (file_exists(_PS_PROD_IMG_DIR_.$ids.($type ? '-'.$type : '').$theme.'.jpg')))
                        || ($not_default = strpos($ids, 'default') !== false))
                {
                        if ($this->allow == 1 && !$not_default)
                                $uri_path = __PS_BASE_URI__.$ids.($type ? '-'.$type : '').$theme.'/'.$name.'.jpg';
                        else
                                $uri_path = _THEME_PROD_DIR_.$ids.($type ? '-'.$type : '').$theme.'.jpg';
                }
                else
                {
                        // if ids if of the form id_product-id_image, we want to extract the id_image part
                        $split_ids = explode('-', $ids);
                        $id_image = (isset($split_ids[1]) ? $split_ids[1] : $split_ids[0]);
                        $theme = ((Shop::isFeatureActive() && file_exists(_PS_PROD_IMG_DIR_.Image::getImgFolderStatic($id_image).$id_image.($type ? '-'.$type : '').'-'.(int)Context::getContext()->shop->id_theme.'.jpg')) ? '-'.Context::getContext()->shop->id_theme : '');
                        $uri_path = _THEME_PROD_DIR_.Image::getImgFolderStatic($id_image).$id_image.($type ? '-'.$type : '').$theme.'.jpg';
                }

                return $this->protocol_content.Tools::getMediaServer($uri_path).$uri_path;
        }

        public function getCatImageLink($name, $id_category, $type = null)
        {
                $uri_path = _THEME_CAT_DIR_.$id_category.($type ? '-'.$type : '').'.jpg';
                return $this->protocol_content.Tools::getMediaServer($uri_path).$uri_path;
        }

        public function getModuleLink($module, $controller = 'default', array $params = array(), $ssl = false, $id_lang = null, $id_shop = null, $relative_protocol = false)
        {
          $base = 'https://';

          if (!$id_lang)
            $id_lang = Context::getContext()->language->id;

          if ($id_shop === null)
            $shop = Context::getContext()->shop;
          else
            $shop = new Shop($id_shop);
          $url = $base.$shop->domain.$shop->getBaseURI().$this->getLangLink($id_lang, null, $id_shop);

          // If the module has its own route ... just use it !
          if (Dispatcher::getInstance()->hasRoute('module-'.$module.'-'.$controller, $id_lang, $id_shop))
            return $this->getPageLink('module-'.$module.'-'.$controller, $ssl, $id_lang, $params);
          else
          {
            // Set available keywords
            $params['module'] = $module;
            $params['controller'] = $controller ? $controller : 'default';
            return $url.Dispatcher::getInstance()->createUrl('module', $id_lang, $params, $this->allow, '', $id_shop);
          }
        }
       
        /**
         * Create a simple link
         *
         * @param string $controller
         * @param bool $ssl
         * @param int $id_lang
         * @param string|array $request
         * @param bool $request_url_encode Use URL encode
         *
         * @return string Page link
         */
        /*
        public function getPageLink($controller, $ssl = false, $id_lang = null, $request = null, $request_url_encode = false, $id_shop = null)
        {
                $controller = Tools::strReplaceFirst('.php', '', $controller);

                if (!$id_lang)
                        $id_lang = (int)Context::getContext()->language->id;

                if (!is_array($request))
                {
                        // @FIXME html_entity_decode has been added due to '&amp;' => '%3B' ...
                        $request = html_entity_decode($request);
                        if ($request_url_encode)
                                $request = urlencode($request);
                        parse_str($request, $request);
                }

                if ($id_shop === null)
                        $shop = Context::getContext()->shop;
                else
                        $shop = new Shop($id_shop);

                $uri_path = Dispatcher::getInstance()->createUrl($controller, $id_lang, $request, false, '', $id_shop);
                $url = 'https://';
                $url .= $shop->domain.$shop->getBaseURI().$this->getLangLink($id_lang, null, $id_shop).ltrim($uri_path, '/');

                return $url;
        } */
}


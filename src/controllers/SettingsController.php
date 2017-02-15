<?php
/**
 * @link      https://dukt.net/craft/twitter/
 * @copyright Copyright (c) 2017, Dukt
 * @license   https://dukt.net/craft/twitter/docs/license
 */

namespace dukt\twitter\controllers;

use Craft;
use craft\web\Controller;
use dukt\twitter\Plugin as Twitter;
use dukt\oauth\Plugin as Oauth;
use Exception;

/**
 * Settings controller
 *
 * @author Dukt <support@dukt.net>
 * @since  3.0
 */
class SettingsController extends Controller
{
    // Public Methods
    // =========================================================================

    /**
     * Settings Index
     *
     * @return null
     */
    public function actionIndex()
    {
        Twitter::$plugin->twitter->requireDependencies();

        $plugin = Craft::$app->plugins->getPlugin('twitter');

        $variables = array(
            'provider' => false,
            'account' => false,
            'token' => false,
            'error' => false
        );

        $provider = Oauth::$plugin->oauth->getProvider('twitter');

        if ($provider && $provider->isConfigured())
        {
            $token = Twitter::$plugin->twitter_oauth->getToken();

            if ($token)
            {
                try
                {
                    $account = Twitter::$plugin->twitter_cache->get(['getAccount', $token]);

                    if(!$account)
                    {
                        $account = $provider->getAccount($token);

                        Twitter::$plugin->twitter_cache->set(['getAccount', $token], $account);
                    }

                    if ($account)
                    {
                        $variables['account'] = $account;
                        $variables['settings'] = $plugin->getSettings();
                    }
                }
                catch(Exception $e)
                {
                    $variables['error'] = $e->getMessage();
                }
            }

            $variables['token'] = $token;

            $variables['provider'] = $provider;
        }

        return $this->renderTemplate('twitter/settings', $variables);
    }
}

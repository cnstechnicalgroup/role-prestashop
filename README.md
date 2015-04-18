Role: cns.prestashop
========

This role installs and configures prestashop.

Requirements
------------

Nothing, it runs out of the box.

Role Variables
--------------

In the current version, you can specify the following variables:

| Name                  | Default |                                                              |
|-----------------------|---------|--------------------------------------------------------------|
| admin_users           |   ---   | List containing all users that require ansible environment.  |
| prestashop_deploy_key |   ---   | git deploy key for site repository (use vault).              |
| web_root              |   ---   | Main root for prestashop install.                            |
| git_repo              |   ---   | Full git repository URL for site checkout.                   |
| git_whitelist         |   ---   | Client IP addresses allowed to access server-side git scripts|
| mysql_server_hostname |   ---   | MySQL server host / proxy name.                              |
| ps_db_name            |   ---   | PrestaShop database name.                                    |
| ps_db_user            |   ---   | PrestaShop database usernem.                                 |
| ps_db_password        |   ---   | PrestaShop database password.                                |
| cache_system          |   ---   | PrestaShop cache system (File System, Memcached, APC, Xcache)|
| cache_enabled         |   ---   | Enable cache? 1=on, 0=off                                    |
| creation_date         |   ---   | Original deploy date.                                        |
| ps_version            |   ---   | Target PrestaShop version.                                   |
| site_public_url       |   ---   | Site URL. The primary site URL.                              |
| cdn_endpoint          |   ---   | Primary CDN end-point.                                       |
| cookie_key            |   ---   | Cookie blowfish key.                                         |
| cookie_iv             |   ---   | Cookie 8-letter IV.                                          |
| rijndael_key          |   ---   | Rijndael mcrypt key.                                         |
| rijndael_iv           |   ---   | Rijndael 8-letter IV.                                        |

Dependencies
------------

Place `robots.txt` in the site playbook `files/` folder. This role will deploy that file to `{{ web_root }}/robots.txt` and add `Disallow: /` to dev deployments.

License
-------

GPLv2

Author Information
------------------

Created by Sam Morrison [@samcns](https://www.twitter.com/samcns)

Examples
--------

```yaml
---
- name: cns.prestashop role test
  hosts: all
  roles:
    - cns.prestashop
```

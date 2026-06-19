<?php

/**
 * SiteMeta - 站点元信息管理类
 * 使用示例数据演示如何保存站点元信息并生成描述文本
 */

class SiteMeta {
    
    private $meta = [];

    public function __construct() {
        // 初始化默认元信息
        $this->meta = [
            'site_name' => '华体会官方平台',
            'domain' => 'https://zhportal-hth.com.cn',
            'keywords' => ['华体会', '体育', '娱乐', '在线平台'],
            'description' => '华体会官方平台提供丰富的体育赛事和娱乐项目。',
            'author' => 'HTH Team',
            'version' => '1.0.0',
            'created_at' => '2024-01-15',
            'updated_at' => date('Y-m-d')
        ];
    }

    /**
     * 设置元信息条目
     */
    public function set($key, $value) {
        $this->meta[$key] = $value;
        return $this;
    }

    /**
     * 获取元信息条目
     */
    public function get($key, $default = null) {
        return isset($this->meta[$key]) ? $this->meta[$key] : $default;
    }

    /**
     * 获取所有元信息
     */
    public function getAll() {
        return $this->meta;
    }

    /**
     * 生成简短描述文本
     * 基于站点名称、域名和关键词组合
     */
    public function generateShortDescription($maxLength = 120) {
        $name = $this->get('site_name', '未知站点');
        $domain = $this->get('domain', '');
        $keywords = $this->get('keywords', []);
        $desc = $this->get('description', '');

        $parts = [];
        $parts[] = $name;
        if (!empty($domain)) {
            $parts[] = $domain;
        }
        if (!empty($desc)) {
            $parts[] = $desc;
        }
        if (!empty($keywords)) {
            $kwStr = implode('、', array_slice($keywords, 0, 3));
            $parts[] = '关键词：' . $kwStr;
        }

        $full = implode(' - ', $parts);
        if (mb_strlen($full) > $maxLength) {
            $full = mb_substr($full, 0, $maxLength - 3) . '...';
        }
        return $full;
    }

    /**
     * 生成带 HTML 转义的元信息标签（示例）
     */
    public function generateMetaTags() {
        $name = htmlspecialchars($this->get('site_name', ''), ENT_QUOTES, 'UTF-8');
        $domain = htmlspecialchars($this->get('domain', ''), ENT_QUOTES, 'UTF-8');
        $desc = htmlspecialchars($this->get('description', ''), ENT_QUOTES, 'UTF-8');
        $keywords = $this->get('keywords', []);
        $kwStr = htmlspecialchars(implode(', ', $keywords), ENT_QUOTES, 'UTF-8');

        $tags = '';
        $tags .= '<meta name="description" content="' . $desc . '" />' . "\n";
        $tags .= '<meta name="keywords" content="' . $kwStr . '" />' . "\n";
        $tags .= '<meta name="author" content="' . htmlspecialchars($this->get('author', ''), ENT_QUOTES, 'UTF-8') . '" />' . "\n";
        $tags .= '<meta property="og:title" content="' . $name . '" />' . "\n";
        $tags .= '<meta property="og:url" content="' . $domain . '" />' . "\n";
        return $tags;
    }
}

// 示例使用
$meta = new SiteMeta();

// 修改一些数据以演示灵活性
$meta->set('site_name', '华体会体育')
     ->set('keywords', ['华体会', '体育赛事', '在线娱乐', 'HTH']);

// 生成描述
echo "简短描述：\n";
echo $meta->generateShortDescription(100) . "\n\n";

echo "所有元信息：\n";
print_r($meta->getAll());

echo "\nHTML Meta 标签：\n";
echo $meta->generateMetaTags();

// 额外的演示：获取单个字段
echo "\n域名：" . $meta->get('domain') . "\n";
echo "版本：" . $meta->get('version') . "\n";
echo "不存在的键：" . $meta->get('nonexistent', '默认值') . "\n";
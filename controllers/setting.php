<?php

class Setting
{
    private $db;

    public function __construct(Database $db)
    {
        $this->db = $db;
    }

    public function getSettings($user_id)
    {
        $stmt = $this->db->getConnection()->prepare("SELECT * FROM user_color_settings WHERE user_id = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        $stmt->close();

        return $result;
    }

    public function saveSettings($user_id, $settings)
    {
        // Check if settings already exist for the user
        $existingSettings = $this->getSettings($user_id);
    
        if ($existingSettings) {
            // Update existing settings
            $stmt = $this->db->getConnection()->prepare("UPDATE user_color_settings SET 
                header_color = ?, header_text_color = ?, 
                button_color = ?, button_text_color = ?, 
                content_color = ?, content_text_color = ?, 
                sidebar_color = ?, sidebar_text_color = ? 
                WHERE user_id = ?");
            
            $stmt->bind_param("ssssssssi", 
                $settings['header_color'], $settings['header_text_color'],
                $settings['button_color'], $settings['button_text_color'],
                $settings['content_color'], $settings['content_text_color'],
                $settings['sidebar_color'], $settings['sidebar_text_color'],
                $user_id
            );
    
            $stmt->execute();
            $stmt->close();
        } else {
            // Insert new settings
            $stmt = $this->db->getConnection()->prepare("INSERT INTO user_color_settings 
                (user_id, header_color, header_text_color, 
                button_color, button_text_color, 
                content_color, content_text_color, 
                sidebar_color, sidebar_text_color) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
            
            $stmt->bind_param("issssssss", 
                $user_id, 
                $settings['header_color'], $settings['header_text_color'],
                $settings['button_color'], $settings['button_text_color'],
                $settings['content_color'], $settings['content_text_color'],
                $settings['sidebar_color'], $settings['sidebar_text_color']
            );
    
            $stmt->execute();
            $stmt->close();
        }
    }
    

    public function resetSettings($user_id)
    {
        // Define static/default values for settings
        $defaultSettings = [
            'header_color' => '#ffffff',
            'header_text_color' => '#000000',
            'button_color' => '#4285f4',
            'button_text_color' => '#ffffff',
            'content_color' => '#ffffff',
            'content_text_color' => '#000000',
            'sidebar_color' => '#f8f9fa',
            'sidebar_text_color' => '#000000',
        ];

        // Save the default settings to the database
        $this->saveSettings($user_id, $defaultSettings);
    }

    // ... (existing code)
}

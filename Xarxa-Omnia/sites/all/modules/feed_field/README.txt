This module creates a CCK field that accepts RSS urls. 
Sponsored by: Promet Source [http://prometsource.com/]

Features:
- Aggregate RSS/Atom feed
- Works with FlexiField
- Controls how many items to display and how frequent are updates

Types of display:
1. Default
2. Teaser
    - Disregards the type of excerpt indicated in the node. It will always display 100 characters, html stripped

3. Full
    - Disregards the type of excerpt indicated in the node. It will always display the full content.
   
Troubleshooting
1. After creating the node, and edit it again, it does not update the feeds
    - Once the feed was already created once, the next update will depend on the info you gave in the "how frequently should the module be updated" question.
    

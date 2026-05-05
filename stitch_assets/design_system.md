# EduCorexa Design System

## Brand & Style

The visual identity of this design system is rooted in the intersection of academic tradition and modern technological efficiency. It is designed to evoke a sense of absolute reliability, precision, and forward-thinking innovation for educational administrators. 

The aesthetic follows a **Corporate Modern** approach. It utilizes a clean, high-contrast framework where generous white space represents clarity of thought, while vibrant indigo-to-purple gradients represent the energy of digital transformation. The interface is structured to reduce cognitive load, ensuring that complex data management tasks feel effortless and organized. The overall mood is one of professional competence, providing a "safe pair of hands" for school operations.

## Layout & Spacing

The layout philosophy follows a **Fixed Grid** model for administrative dashboards to ensure information density remains predictable across desktop screens. A 12-column grid system is used with 24px (1.5rem) gutters to allow for complex module arrangements.

Spacing follows an 8px base unit rhythm, promoting a disciplined vertical flow. Generous section padding (80px+) is used on informational landing pages to separate value propositions, while the internal application views utilize tighter margins to maximize the "above the fold" visibility of critical data tables and management tools.

## Elevation & Depth

Visual hierarchy is established through a combination of **Tonal Layers** and **Ambient Shadows**. The design avoids harsh shadows in favor of extra-diffused, low-opacity shadows (e.g., 0px 4px 20px rgba(15, 23, 42, 0.05)) to lift cards and containers off the #F8FAFC background.

To denote higher importance or "active" modals, a subtle color tinting is applied to the shadow using the primary indigo hue. This creates a sense of depth that feels integrated with the brand rather than artificial. Borders are used sparingly, primarily as low-contrast outlines (#E2E8F0) to define structural boundaries without adding visual noise.

## Components

### Buttons
Primary buttons feature the signature blue-to-purple gradient with white text and a subtle drop shadow. Secondary buttons use a ghost style with a 1px border in #4F46E5. All buttons should have a minimum height of 48px for high-traffic administrative actions to ensure ease of use.

### Input Fields
Inputs are styled with #F8FAFC backgrounds and subtle #E2E8F0 borders. Upon focus, the border transitions to the primary indigo with a soft outer glow. Labels are placed above the field in Inter (Semi-Bold) for maximum clarity during data entry.

### Cards
Dashboard cards are the primary container for data modules. They feature a white background, 16px corner radius, and a soft ambient shadow. Every card should include a consistent header style with a colored icon representative of the module (e.g., green for attendance, red for fees).

### Chips & Badges
Used for status indicators (e.g., "Paid", "Present", "Pending"). These utilize a soft pastel background derived from the status color with high-contrast text, maintaining the 8px roundedness found throughout the system.

### Iconography
High-quality, line-based icons with a consistent stroke weight are essential. Icons should be housed in soft-colored circular or squared-off "blobs" to add a layer of visual interest to the navigational sidebar and module headers.

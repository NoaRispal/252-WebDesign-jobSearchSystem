# Setting up the Figma MCP Server

This guide explains how to set up the **Figma MCP Server** included in the `figma-mcp-server` directory.

Unlike the official Figma MCP server (which is read-only), **this community project allows AI Agents to actually make changes directly to your Figma documents.**

The architecture works via an Express/WebSocket server bridging the AI Agent and a custom local Figma Plugin. Both the Plugin and the Server must be running for this to work.

---

## Prerequisites
* You must have **Node.js** installed on your computer.

---

## Step 1: Install & Start the Figma Plugin
The plugin listens to the MCP server and applies the changes directly to your open Figma file.

1. Open a terminal and navigate to the plugin directory:
   ```bash
   cd figma-mcp-server/plugin
   ```
2. Install the necessary dependencies:
   ```bash
   npm i
   ```
3. Build the plugin:
   ```bash
   npm run build
   ```
4. Open the Figma desktop app and open the document you want the AI to interact with.
5. In Figma, go to **Plugins** > **Development** > **Import plugin from manifest...**
6. Select the `manifest.json` file located inside `figma-mcp-server/plugin/manifest.json`.
7. Start the plugin from the menu. You should see a message saying *"Not connected to MCP server"*. Do not close this tiny plugin window!

---

## Step 2: Install & Start the MCP Server
This is the server that your AI Agent (like Claude or Cursor) will connect to.

1. Open a *new* separate terminal and navigate to the MCP directory:
   ```bash
   cd figma-mcp-server/mcp
   ```
2. Install dependencies:
   ```bash
   npm i
   ```
3. Start the server:
   ```bash
   npm run start
   ```
4. Look at the console. You should see `Server listening on http://localhost:38450`.
5. Look back at your open Figma Plugin window. It should now say *"Connected to MCP server"*.

---

## Step 3: Configure Your AI Client
Now that the bridge is running, you just need to tell your AI client where to connect.

1. Add a new MCP server in your AI tool's settings.
2. Select **Streaming HTTP** or **SSE (Server-Sent Events)** as the transport method.
3. Use the following URL for the connection:
   ```url
   http://localhost:38450/mcp
   ```

**You're done!** You can now ask your AI Agent to create rectangles, update text, read layer structures, and visually implement designs directly inside your active Figma file.

*(Note: Ensure you are only running this on your local machine to keep your Figma files secure).*

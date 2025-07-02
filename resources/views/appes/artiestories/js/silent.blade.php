
  <script>
    const originalLog = console.log;
    console.log = function (...args) {
      if (args.some(arg => typeof arg === 'string' && arg.includes('Pusher')) ||
          args.some(arg => typeof arg === 'string' && arg.includes('broadcast.typing1')) || 
          args.some(arg => typeof arg === 'string' && arg.includes('user.typing1')) ||
          args.some(arg => typeof arg === 'string' && arg.includes('Pusher1')) ||
          args.some(arg => typeof arg === 'string' && arg.includes('broadcast.typing')) ||
          args.some(arg => typeof arg === 'string' && arg.includes('user.typing'))) {
          return;
      }
      originalLog.apply(console, args);
    };        
  </script>
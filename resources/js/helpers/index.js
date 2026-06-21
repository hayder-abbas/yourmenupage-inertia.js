/**
 * Converts a time to a string by using the current or specified locale.
 * Make the value hour12 changeable because the specified value (e.g. 07:00 AM)
 * does not conform to the required input type format for time for update restaurant info.
 */
export const toTimeUTC = (time, _hour12 = false) => {
    return new Date(time).toLocaleTimeString("en-US", {
        hour12: _hour12,
        hour: "2-digit",
        minute: "2-digit",
        timeZone: "UTC",
    });
};

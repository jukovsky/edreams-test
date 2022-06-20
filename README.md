## Test Details

Implement a "hotel availability search" API that returns the best fare for a package of rooms on a given date.  
In order to do so, we should check several upstream providers and return the fare with the highest margin (price -
commission).

### Functional Requirements:

- Provider "Fraught Lodgings" has provided their inventory and availability in data/fraught-lodgings.yaml. They charge
  us a 5% commission on each package booked.
- Provider "Fantastic Yurts" has provided their inventory and availability in data/fantastic-yurts.yaml. Their
  commission is a flat 5 euro fee per room booked.
- We plan to add more providers soon, to whom we will connect via API.
- Children under the age of 13 must never be alone in a room without adults.

### Examples

- A search for a room for 3 adults from Jan-1-2022 through Jan-2-2022, should return a package containing rooms 4
  and 5 from "American West Yurt", as American West Yurt is the only hotel with availability on those dates,
  and those are the cheapest rooms that can fit all guests.
- Indian Burial Ground Yurts is available from both providers for the night of Jan 6. The prices are the same, but
  due to the commissions structure, the margin is preferable from Fantastic Yurts.
- A search for a room for 5 adults for the same dates should return a package of 2 rooms, since not everyone can fit in
  rooms 3 and 4.
- The cheapest option for 4 guests for the dates Jan-3-2022 through Jan-5-2022, is in Yangtze River Yurts. However,
  if 3 of the guests are children, this combination is not valid. The next best price is room 2 at Unsavory Company
  Hostel.

## Developer comments

Obviously to provide more accurate and flexible architecture we should collect more requirements and know more about
business processes. This is a very draft solution that provides only basic concepts and possible architectures and
implementation.
I didn't change the entry point of the code, so one can use URLs like:
http://localhost:8887/?fromDate=2022-01-06&toDate=2022-01-06&adults=3

### Further improvements

- For sure, the code should be covered with tests. Current tests are just simple variant that didn't check real
  functional requirements.
- All client-server communication should be protected. For example, we can use JWT.
- For all input data we should use validation and hydration. In the case of using databases, the current code is totally
  unsecured against injections, for example.
- Custom error classes.
- Cache system. The existing two provider classes preload data and store it. In real life, we should load data
  dynamically.
  But maybe based on business processes it could be stored for some periods to improve timings.
- In real world when we have to deal with dozens of different providers, we should use queues, for example, to return
  results by portions. So we can show the progress for users or show partial results.
- It is better to implement DI via containers.

### Current architecture

- I prefer to store business logic in services. To keep controllers as thin as possible. In case of using data layer
  additional repository layer should be provided.
- Currently, two provider classes are more or less just a copy-paste of each other. So in this case it would be better
  to implement one class to work with JSON data and use decomposition to provide additional interface which calculates
  commissions. But existing solution is based on the assumption that different providers use completely different APIs.
- A GET method was used, but in real world we have to deal with more sophisticated filters with complex structure. So
  POST method could be preferable. Even if it's against basic REST principles.
- I prefer not to use 'Interface' suffix as it's easier to add flexibility to application by replacing existing
  particular class with interface.